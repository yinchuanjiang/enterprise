<?php

namespace App\Admin\Controllers;

use App\Admin\Export\KnowledgeExporter;
use App\Models\BaseKeywords;
use App\Models\Enum\BaseParameterEnum;
use App\Models\Enum\StoreCompanyEnum;
use App\Models\Enum\StoreKnowledgeEnum;
use App\Models\StoreKnowledge;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class KnowLedgeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '知识库管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new StoreKnowledge);
        $grid->model()->orderBy('knowledge_id','desc');
        $grid->column('knowledge_id', 'ID');
        $grid->column('classify.type_value', '知识库类别')->label('info')->filter(BaseParameterEnum::getListKnowledgeCategories());
        $grid->column('company.company_name', '所属企业')->label('success');
        $grid->column('knowledge_name', '名称')->filter('like');
        $grid->column('knowledge_number', '编号')->filter('like');
        $grid->column('isauthorize', '是否授权')->display(function ($isauthorize){
            return StoreKnowledgeEnum::getIsauthorizeName($isauthorize);
        })->label('default')->filter(StoreKnowledgeEnum::getIsauthorizes());
        $grid->column('create_time', '创建时间');
        $grid->exporter(new KnowledgeExporter());
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
        $show = new Show(StoreKnowledge::findOrFail($id));

        $show->field('knowledge_id', __('Knowledge id'));
        $show->field('classify_id', __('Classify id'));
        $show->field('company_id', __('Company id'));
        $show->field('knowledge_name', __('Knowledge name'));
        $show->field('knowledge_number', __('Knowledge number'));
        $show->field('isauthorize', __('Isauthorize'));
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
        $form = new Form(new StoreKnowledge);
        $form->ignore(['keyword','indetails']);
        $form->select('classify_id', '类别')->options(BaseParameterEnum::getListKnowledgeCategories())->required();
        $form->select('company_id','所属企业')->options(StoreCompanyEnum::getCompanies())->required();
        $form->text('knowledge_name', '名称')->required();
        $form->text('knowledge_number', '编号')->required();
        $form->cascade('indetails','行业明细');
        if($form->isEditing()){
            $id = last(explode('/',str_replace('/edit','',url()->current())));
            $form->tags('keyword', '搜索关键词')->default(StoreKnowledge::find($id)->keyword);
        }else {
            $form->tags('keyword', '搜索关键词');
        }
        //$form->image('knowledge_pic','专利图片');
        $form->textarea('knowledge_desc','专利介绍');
        $form->radio('isauthorize', '是否授权')->options(StoreKnowledgeEnum::getIsauthorizes())->default(StoreKnowledgeEnum::ISAUTHORIZE_FALSE)->required();

        $form->saved(function (Form $form){
            $storeKonwLedge = $form->model();
            $store = DB::table('t_base_store')->where('store_code','knowledge')->first();
            $indetails = request('indetails');
            if($indetails){
                //$storePolicy->indetails()->delete();
                DB::table('t_store_store_category')->where(['record_id' => $storeKonwLedge->knowledge_id,'store_id' => $store->store_id])->delete();
                $indetails = explode(',',$indetails);
                foreach ($indetails as $indetail){
                    DB::table('t_store_store_category')->insert(['record_id' => $storeKonwLedge->knowledge_id,'store_id' => $store->store_id,'category_id' => $indetail]);
                }
            }

            $kewords = request('keyword');
            if($kewords){
                //$storePolicy->keywords()->delete();
                DB::table('t_store_store_keywords')->where(['record_id' => $storeKonwLedge->knowledge_id,'store_id' => $store->store_id])->delete();
                $kewords = explode(',',$kewords);
                foreach ($kewords as $keword){
                    $baseKeywords = BaseKeywords::where('keywords_name',$keword)->first();
                    if(!$baseKeywords) {
                        $baseKeywords = BaseKeywords::create(['keywords_name' => $keword]);
                    }
                    DB::table('t_store_store_keywords')->insert(['record_id' => $storeKonwLedge->knowledge_id,'keywords_id' => $baseKeywords->keywords_id,'store_id' => $store->store_id]);
                }
            }
        });

        return $form;
    }
}
