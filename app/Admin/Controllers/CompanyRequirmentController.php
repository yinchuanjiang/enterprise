<?php

namespace App\Admin\Controllers;

use App\Admin\Export\CompanyRequirmentExporter;
use App\Models\BaseCategory;
use App\Models\BaseKeywords;
use App\Models\CompanyRequirment;
use App\Models\Enum\BaseParameterEnum;
use App\Models\Enum\StoreCompanyEnum;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class CompanyRequirmentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '企业需求库管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CompanyRequirment);

        $grid->column('req_id', 'ID');
        $grid->column('company.company_name', '企业')->label('info');
        $grid->column('type.type_value', '需求类型')->label('success');
        $grid->column('contact_name', '联系人');
        $grid->column('contact_phone', '联系方式');
        $grid->column('create_time', '创建时间');
        $grid->exporter(new CompanyRequirmentExporter());
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
        $show = new Show(CompanyRequirment::findOrFail($id));

        $show->field('req_id', __('Req id'));
        $show->field('company_id', __('Company id'));
        $show->field('req_type', __('Req type'));
        $show->field('req_tag', __('Req tag'));
        $show->field('req_content', __('Req content'));
        $show->field('contact_name', __('Contact name'));
        $show->field('contact_phone', __('Contact phone'));
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
        $form = new Form(new CompanyRequirment);
        $form->ignore(['keyword','indetails']);
        $form->select('company_id', '企业')->options(StoreCompanyEnum::getCompanies());
        $form->select('req_type', '需求类型')->options(BaseParameterEnum::getListCompanyRequirmentCategories());
        $form->multipleSelect('teches','应用领域')->options(BaseCategory::selectOptions(null,'',7));
        $form->cascade('indetails','行业明细');
        if($form->isEditing()){
            $id = last(explode('/',str_replace('/edit','',url()->current())));
            $form->tags('keyword', '搜索关键词')->default(CompanyRequirment::find($id)->keyword);
        }else {
            $form->tags('keyword', '搜索关键词');
        }
        //$form->text('req_tag', '需求标签');
        $form->textarea('req_content', '需求内容');
        $form->text('contact_name', '联系人');
        $form->text('contact_phone', '联系方式');
        $form->saved(function (Form $form){
            $companyRequirment = $form->model();
            $store = DB::table('t_base_store')->where('store_code','requirment')->first();
            $indetails = request('indetails');
            if($indetails){
                //$storePolicy->indetails()->delete();
                DB::table('t_store_store_category')->where(['record_id' => $companyRequirment->req_id,'store_id' => $store->store_id])->delete();
                $indetails = explode(',',$indetails);
                foreach ($indetails as $indetail){
                    DB::table('t_store_store_category')->insert(['record_id' => $companyRequirment->req_id,'store_id' => $store->store_id,'category_id' => $indetail]);
                }
            }

            $kewords = request('keyword');
            if($kewords){
                //$storePolicy->keywords()->delete();
                DB::table('t_store_store_keywords')->where(['record_id' => $companyRequirment->req_id,'store_id' => $store->store_id])->delete();
                $kewords = explode(',',$kewords);
                foreach ($kewords as $keword){
                    $baseKeywords = BaseKeywords::where('keywords_name',$keword)->first();
                    if(!$baseKeywords) {
                        $baseKeywords = BaseKeywords::create(['keywords_name' => $keword]);
                    }
                    DB::table('t_store_store_keywords')->insert(['record_id' => $companyRequirment->req_id,'keywords_id' => $baseKeywords->keywords_id,'store_id' => $store->store_id]);
                }
            }
        });
        return $form;
    }
}
