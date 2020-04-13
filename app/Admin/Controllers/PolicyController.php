<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Policy\Push;
use App\Admin\Actions\Policy\PushPoint;
use App\Admin\Actions\Policy\PushType;
use App\Admin\Export\PolicyExporter;
use App\Models\BaseCategory;
use App\Models\BaseKeywords;
use App\Models\Enum\BaseGovernmentEnum;
use App\Models\Enum\BaseParameterEnum;
use App\Models\Enum\StorePolicyEnum;
use App\Models\StorePolicy;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class PolicyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '政策库管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new StorePolicy);

        $grid->column('policy_id', __('ID'));
        $grid->column('policy_title', '政策标题')->filter('like');
//        $grid->column('policy_author', '政策作者')->filter('like');
        $grid->column('policy_label', '政策标签')->filter('like');
        $grid->column('start_time', '开始时间')->filter('range','datetime');
        $grid->column('end_time', '结束时间')->filter('range','datetime');
        $grid->column('publish_date', '发布日期')->filter('range','datetime');
        $grid->column('declare_flag','是否申报')->display(function ($declare_flag){
            return StorePolicyEnum::getDeclareFlagName($declare_flag);
        })->label('success')->filter(StorePolicyEnum::getDeclareFlags());
        $grid->column('views', '浏览次数')->display(function ($views){
            if(!$views)
                return 0;
            return $views;
        })->sortable();
        $grid->column('create_time', '创建时间')->filter('range','datetime');
        $grid->exporter(new PolicyExporter());
        $grid->actions(function ($actions) {
            // 去掉查看
            $actions->disableView();
            $actions->disableDelete();
            $actions->add(new PushType());
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new Push());
        });

        $this->script = <<<EOL
        $('#app-admin-actions-policy-push .modal-body').append('<iframe src="/admin/users/html" width="100%" height="600" frameborder="no" border="0"></iframe>');
        $('#app-admin-actions-policy-push .btn-primary').click(function(){
            $('input[name="user_id"]').val(window.localStorage.getItem('userId'));
        });
EOL;
        Admin::script($this->script);

        return $grid;
    }



    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(StorePolicy::findOrFail($id));

        $show->field('policy_id', __('Policy id'));
        $show->field('policy_title', __('Policy title'));
        $show->field('policy_content', __('Policy content'));
        $show->field('policy_description', __('Policy description'));
        $show->field('policy_author', __('Policy author'));
        $show->field('policy_label', __('Policy label'));
        $show->field('policy_range', __('Policy range'));
        $show->field('policy_type', __('Policy type'));
        $show->field('start_time', __('Start time'));
        $show->field('end_time', __('End time'));
        $show->field('source_url', __('Source url'));
        $show->field('publish_date', __('Publish date'));
        $show->field('declare_flag', __('Declare flag'));
        $show->field('declare_title', __('Declare title'));
        $show->field('declare_units', __('Declare units'));
        $show->field('declare_requirement', __('Declare requirement'));
        $show->field('declare_range', __('Declare range'));
        $show->field('declare_subsidy', __('Declare subsidy'));
        $show->field('declare_contact', __('Declare contact'));
        $show->field('declare_deadline', __('Declare deadline'));
        $show->field('audit_status', __('Audit status'));
        $show->field('views', __('Views'));
        $show->field('create_time', __('Create time'));
        $show->field('update_time', __('Update time'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new StorePolicy);
        $form->ignore(['keyword','indetails']);
        $form->text('policy_title', '政策标题')->required();
        $form->text('policy_description', '政策摘要')->required();
//        $form->text('policy_author', '政策作者')->required();
        $form->text('policy_label', '政策标签')->required();
        $form->textarea('policy_range', '政策范围')->required();
        $form->radio('module_type', '政策类别')->options(StorePolicyEnum::getPolicyTypes())->default(StorePolicyEnum::POLICY_TYPE_APPLY_NOTICE)->required();
        $form->datetime('start_time', '开始时间')->default(date('Y-m-d H:i:s'))->required();
        $form->datetime('end_time', '结束时间')->default(date('Y-m-d H:i:s'))->required();
        $form->text('source_url', '来源网址')->required();
        $form->datetime('publish_date', '发布日期')->default(date('Y-m-d H:i:s'))->required();
        $form->listbox('governments','发文单位')->options(BaseGovernmentEnum::getListBoxGovernments());
        //$form->multipleSelect('indetails','行业明细')->options(BaseCategory::selectOptions(null,'ROOT',1));
        $form->cascade('indetails','行业明细');
        if($form->isEditing()){
            $id = last(explode('/',str_replace('/edit','',url()->current())));
            $form->tags('keyword', '搜索关键词')->default(StorePolicy::find($id)->keyword);
        }else {
            $form->tags('keyword', '搜索关键词');
        }
        $form->listbox('categories','政策类别')->options(BaseParameterEnum::getListPolicyCategories());
        $form->editor('policy_content', '政策内容')->required();
        $form->radio('declare_flag', '申报标识')->options(StorePolicyEnum::getDeclareFlags())->default(StorePolicyEnum::DECLARE_FLAG_FALSE)->required();
        $form->text('declare_title', '申报主题');
        $form->text('declare_units', '申报单位');
        $form->textarea('declare_requirement', '申报条件');
        $form->textarea('declare_range', '申报范围');
        $form->text('declare_subsidy', '补贴额度');
        $form->text('declare_contact', '联系方式')->icon('fa-phone');
        $form->datetime('declare_deadline', '截止时间')->default(date('Y-m-d H:i:s'));
        $form->switch('audit_status', '审核')->states(StorePolicyEnum::getSwitchAuditStatus());

        $form->saving(function (Form $form){
//            $indetails = explode(',',$form->indetails);
//            $form->indetails = $indetails;
        });

        $form->saved(function (Form $form){
            $storePolicy = $form->model();
            $store = DB::table('t_base_store')->where('store_code','policy')->first();
            $indetails = request('indetails');
            if($indetails){
                //$storePolicy->indetails()->delete();
                DB::table('t_store_store_category')->where(['record_id' => $storePolicy->policy_id,'store_id' => $store->store_id])->delete();
                $indetails = explode(',',$indetails);
                foreach ($indetails as $indetail){
                    DB::table('t_store_store_category')->insert(['record_id' => $storePolicy->policy_id,'store_id' => $store->store_id,'category_id' => $indetail]);
                }
            }

            $kewords = request('keyword');
            if($kewords){
                //$storePolicy->keywords()->delete();
                DB::table('t_store_store_keywords')->where(['record_id' => $storePolicy->policy_id,'store_id' => $store->store_id])->delete();
                $kewords = explode(',',$kewords);
                foreach ($kewords as $keword){
                    $baseKeywords = BaseKeywords::where('keywords_name',$keword)->first();
                    if(!$baseKeywords) {
                        $baseKeywords = BaseKeywords::create(['keywords_name' => $keword]);
                    }
                    DB::table('t_store_store_keywords')->insert(['record_id' => $storePolicy->policy_id,'keywords_id' => $baseKeywords->keywords_id,'store_id' => $store->store_id]);
                }
            }
        });
        $prefix = config('admin.route.prefix');
        $this->script = <<<EOT
        $("body").on("select2:select",".indetails",function(e){
            　　  // e 的话就是一个对象 然后需要什么就 “e.参数” 形式 进行获取
            　　console.log(e);
            let ids = $("select[name='indetails[]']").val();
            $.get("/$prefix/policies/keywords",{ids},function(res){
                if(res.status){
                    $(".keyword").tagsinput('removeAll');
                    $(".keyword").tagsinput('add', res.data);
                }
            });
        })
        $("body").on("select2:unselect",".indetails",function(e){
            let ids = $("select[name='indetails[]']").val();
            $.get("/$prefix/policies/keywords",{ids},function(res){
                if(res.status){
                    $(".keyword").tagsinput('removeAll');
                    $(".keyword").tagsinput('add', res.data);
                }
            });
        });
EOT;
        Admin::script($this->script);

        return $form;
    }

    public function keywords()
    {
        $ids = request('ids');
        if(!$ids)
            return ['status' => 400,'data' => ''];
        $keywordIds = DB::table('t_store_category_keywords')->whereIn('category_id',$ids)->pluck('keywords_id');
        if(!$keywordIds)
            return ['status' => 400,'data' => ''];
        $keywords = DB::table('t_base_keywords')->whereIn('keywords_id',$keywordIds)->pluck('keywords_name')->toArray();
        if(!$keywords)
            return ['status' => 400,'data' => ''];
        return ['status' => 200,'data' => implode(',',$keywords)];
    }
}
