<?php

namespace App\Admin\Controllers;

use App\Admin\Export\NewtechproductsExporter;
use App\Models\BaseCategory;
use App\Models\BaseKeywords;
use App\Models\Enum\NewtechproductEnum;
use App\Models\Newtechproduct;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class NewtechproductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '新技术新产品库管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Newtechproduct);

        $grid->column('ntp_id', 'ID');
        $grid->column('ntp_type', '分类')->display(function ($type){
            return NewtechproductEnum::getTypeName($type);
        })->label('info')->filter(NewtechproductEnum::getTypes());
        $grid->column('ntp_name', '成果名称')->filter('like');
        $grid->column('ntp_holder', '项目持有人')->filter('like');
        $grid->column('ntp_stage', '所处阶段')->filter('like');
        $grid->column('create_time', '创建时间');
        $grid->exporter(new NewtechproductsExporter());
        $grid->actions(function ($actions) {
            // 去掉查看
            $actions->disableView();
        });
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
        $show = new Show(Newtechproduct::findOrFail($id));

        $show->field('ntp_id', 'ID');
        $show->field('ntp_type', '分类');
        $show->field('ntp_name', '成果名称');
        $show->field('ntp_holder', __('Ntp holder'));
        $show->field('ntp_case', __('Ntp case'));
        $show->field('ntp_stage', __('Ntp stage'));
        $show->field('contact_name', __('Contact name'));
        $show->field('contact_tel', __('Contact tel'));
        $show->field('keywords', __('Keywords'));
        $show->field('ntp_content', __('Ntp content'));
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
        $form = new Form(new Newtechproduct);
        $form->ignore(['keyword','indetails']);
        $form->radio('ntp_type', '分类')->options(NewtechproductEnum::getTypes())->default(NewtechproductEnum::TYPE_NEW_TECH);
        $form->text('ntp_name', '成果名称')->required();
        $form->multipleSelect('techapps','应用领域')->options(BaseCategory::selectOptions(null,'',7));
        $form->text('ntp_holder', '项目持有人')->required();
        $form->textarea('ntp_case', '运用案例与运用场景');
        $form->text('ntp_stage', '所处阶段')->required();
        $form->text('contact_name', '联系人')->required();
        $form->text('contact_tel', '联系电话')->required();
        $form->cascade('indetails','行业明细');
        if($form->isEditing()){
            $id = last(explode('/',str_replace('/edit','',url()->current())));
            $form->tags('keyword', '搜索关键词')->default(Newtechproduct::find($id)->keyword);
        }else {
            $form->tags('keyword', '搜索关键词');
        }
        $form->editor('ntp_content', '成果内容');

        $form->saved(function (Form $form){
            $newtechproduct = $form->model();
            $store = DB::table('t_base_store')->where('store_code','newtechproduct')->first();
            $indetails = request('indetails');
            if($indetails){
                //$storePolicy->indetails()->delete();
                DB::table('t_store_store_category')->where(['record_id' => $newtechproduct->ntp_id,'store_id' => $store->store_id])->delete();
                $indetails = explode(',',$indetails);
                foreach ($indetails as $indetail){
                    DB::table('t_store_store_category')->insert(['record_id' => $newtechproduct->ntp_id,'store_id' => $store->store_id,'category_id' => $indetail]);
                }
            }

            $kewords = request('keyword');
            if($kewords){
                //$storePolicy->keywords()->delete();
                DB::table('t_store_store_keywords')->where(['record_id' => $newtechproduct->ntp_id,'store_id' => $store->store_id])->delete();
                $kewords = explode(',',$kewords);
                foreach ($kewords as $keword){
                    $baseKeywords = BaseKeywords::where('keywords_name',$keword)->first();
                    if(!$baseKeywords) {
                        $baseKeywords = BaseKeywords::create(['keywords_name' => $keword]);
                    }
                    DB::table('t_store_store_keywords')->insert(['record_id' => $newtechproduct->ntp_id,'keywords_id' => $baseKeywords->keywords_id,'store_id' => $store->store_id]);
                }
            }
        });

        return $form;
    }
}
