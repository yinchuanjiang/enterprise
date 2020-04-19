<?php

namespace App\Admin\Controllers;

use App\Admin\Export\CompanyExporter;
use App\Models\BaseCategory;
use App\Models\BaseKeywords;
use App\Models\Enum\BaseGovernmentEnum;
use App\Models\Enum\BaseParameterEnum;
use App\Models\Enum\StoreCompanyEnum;
use App\Models\StoreCompany;
use Encore\Admin\Admin;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class CompanyController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '企业库管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new StoreCompany);
        $grid->model()->orderBy('company_id','desc');
        $grid->column('company_id', 'ID');
        $grid->column('company_name', '企业名称');
        $grid->column('is_high', '是否高新')->display(function ($isHigh){
            return StoreCompanyEnum::getIsHighName($isHigh);
        })->label('info');
        $grid->column('register_time', '注册时间');
        $grid->column('company_seq','排序')->editable();
        $grid->exporter(new CompanyExporter());
        $grid->actions(function ($actions) {
            // 去掉查看
            $actions->disableView();
        });
        $grid->disableBatchActions();
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
        $show = new Show(StoreCompany::findOrFail($id));

        $show->field('company_name', '企业名称');
        $show->field('company_introduction', '企业介绍');
        $show->field('company_address', '企业地址');
        $show->field('company_nature', __('Company nature'));
        $show->field('company_scope', __('Company scope'));
        $show->field('company_filed', __('Company filed'));
        $show->field('company_spot', __('Company spot'));
        $show->field('business_license_pic', __('Business license pic'));
        $show->field('is_high', __('Is high'));
        $show->field('register_time', __('Register time'));
        $show->field('register_money', __('Register money'));
        $show->field('register_address', __('Register address'));
        $show->field('corporation_name', __('Corporation name'));
        $show->field('corporation_call', __('Corporation call'));
        $show->field('corporation_phone', __('Corporation phone'));
        $show->field('contact_name', __('Contact name'));
        $show->field('contact_tell', __('Contact tell'));
        $show->field('contact_phone', __('Contact phone'));
        $show->field('contact_email', __('Contact email'));
        $show->field('staff_number_total', __('Staff number total'));
        $show->field('staff_number_college', __('Staff number college'));
        $show->field('staff_number_bachelor', __('Staff number bachelor'));
        $show->field('staff_number_master', __('Staff number master'));
        $show->field('staff_number_returnee', __('Staff number returnee'));
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
        $form = new Form(new StoreCompany);
        $form->ignore(['keyword','fielddetails']);
        $form->fieldset('企业基本信息', function (Form $form) {
            $form->text('company_name', '企业名称');
            $form->select('company_nature', '企业性质')->options(StoreCompanyEnum::getCompanyScopes())->default('企业');
            //$form->text('company_address', '企业地址')->icon('fa-map-marker');
            $form->datetime('register_time', '注册时间')->default(date('Y-m-d H:i:s'));
            //$form->image('business_license_pic', '营业执照图片');
            $form->text('register_address', '注册地址')->icon('fa-map-marker');
            $form->cascade('fielddetails','行业明细');
            $form->text('company_seq', '排序')->setWidth(2,2)->default(0)->help('数字小排序靠前')->rules('numeric',[
                'numeric' => '排序必须是数字'
            ])->icon('fa-sort-numeric-asc');
            if($form->isEditing()){
                $id = last(explode('/',str_replace('/edit','',url()->current())));
                $form->tags('keyword', '搜索关键词')->default(StoreCompany::find($id)->keyword);
            }else {
                $form->tags('keyword', '搜索关键词');
            }
            //$form->multipleSelect('fielddetails','行业明细')->options(BaseCategory::selectOptions(null,'ROOT',1));
            $form->listbox('governments','发文单位')->options(BaseGovernmentEnum::getListBoxGovernments());
            $form->listbox('policycategories','政策类别')->options(BaseParameterEnum::getListPolicyCategories());
        });
        $form->fieldset('企业扩展信息', function (Form $form) {
            $form->textarea('company_introduction', '企业介绍');
            $form->textarea('company_scope', '企业范围');
            $form->textarea('company_filed', '企业领域');
            $form->textarea('company_spot', '企业亮点');
            $form->radio('is_high', '是否高新')->options(StoreCompanyEnum::getIsHighs())->default(StoreCompanyEnum::IS_HIGH_FALSE);
            $form->text('register_money', '注册资本(万)')->icon('fa-cny');
            $form->text('corporation_name', '法人姓名')->icon('fa-user');
            $form->text('corporation_call', '法人称呼');
            $form->text('corporation_phone', '法人电话')->icon('fa-phone');
            $form->text('contact_name', '联系人姓名');
            $form->text('contact_tell', '联系人固话')->icon('fa-phone');
            $form->text('contact_phone', '联系人手机')->icon('fa-phone');
            $form->text('contact_email', '联系人电子邮箱')->icon('fa-envelope-o');
            $form->text('staff_number_total', '员工数量');
            $form->text('staff_number_college', '专科数量');
            $form->text('staff_number_bachelor', '本科数量');
            $form->text('staff_number_master', '硕士数量');
            $form->text('staff_number_returnee', '海归数量');
        });

        $form->saved(function (Form $form){
            $storeCompany = $form->model();
            $store = DB::table('t_base_store')->where('store_code','company')->first();

            $indetails = request('fielddetails');
            if($indetails){
                //$storePolicy->indetails()->delete();
                DB::table('t_store_store_category')->where(['record_id' => $storeCompany->company_id,'store_id' => $store->store_id])->delete();
                $indetails = explode(',',$indetails);
                foreach ($indetails as $indetail){
                    DB::table('t_store_store_category')->insert(['record_id' => $storeCompany->company_id,'store_id' => $store->store_id,'category_id' => $indetail]);
                }
            }

            $kewords = request('keyword');
            if($kewords){
                //$storePolicy->keywords()->delete();
                DB::table('t_store_store_keywords')->where(['record_id' => $storeCompany->company_id,'store_id' => $store->store_id])->delete();
                $kewords = explode(',',$kewords);
                foreach ($kewords as $keword){
                    $baseKeywords = BaseKeywords::where('keywords_name',$keword)->first();
                    if(!$baseKeywords) {
                        $baseKeywords = BaseKeywords::create(['keywords_name' => $keword]);
                    }
                    DB::table('t_store_store_keywords')->insert(['record_id' => $storeCompany->company_id,'keywords_id' => $baseKeywords->keywords_id,'store_id' => $store->store_id]);
                }
            }
        });

        $prefix = config('admin.route.prefix');
        $this->script = <<<EOT
        $("body").on("select2:select",".fielddetails",function(e){
            　　  // e 的话就是一个对象 然后需要什么就 “e.参数” 形式 进行获取
            　　console.log(e);
            let ids = $("select[name='fielddetails[]']").val();
            $.get("/$prefix/policies/keywords",{ids},function(res){
                if(res.status){
                    $(".keyword").tagsinput('removeAll');
                    $(".keyword").tagsinput('add', res.data);
                }
            });
        })
        $("body").on("select2:unselect",".fielddetails",function(e){
            let ids = $("select[name='fielddetails[]']").val();
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
}
