<?php

namespace App\Admin\Controllers;

use App\Admin\Export\TalentExporter;
use App\Models\BaseCategory;
use App\Models\BaseKeywords;
use App\Models\Enum\TalentEnum;
use App\Models\Talent;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;

class TalentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '专家人才库管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Talent);

        $grid->column('talents_id', 'ID');
        $grid->column('name', '姓名')->filter('like');
        $grid->column('sex', '性别')->filter('like');
        $grid->column('jobtitle', '工作单位及职务')->filter('like');
        $grid->column('education', '学历学位')->filter('like');
        $grid->column('university', '毕业院校与专业')->filter('like');
        $grid->column('major', '目前的专业/技术特长')->filter('like');
        $grid->column('linkphone', '联系电话')->filter('like');
        $grid->exporter(new TalentExporter());
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
        $show = new Show(Talent::findOrFail($id));

        $show->field('talents_id', __('Talents id'));
        $show->field('name', __('Name'));
        $show->field('sex', __('Sex'));
        $show->field('jobtitle', __('Jobtitle'));
        $show->field('birthday', __('Birthday'));
        $show->field('nationality', __('Nationality'));
        $show->field('major', __('Major'));
        $show->field('introduce', __('Introduce'));
        $show->field('university', __('University'));
        $show->field('education', __('Education'));
        $show->field('studyabroad', __('Studyabroad'));
        $show->field('gainhonor', __('Gainhonor'));
        $show->field('linkphone', __('Linkphone'));
        $show->field('email', __('Email'));
        $show->field('longorshort', __('Longorshort'));
        $show->field('remark', __('Remark'));
        $show->field('luyangtime', __('Luyangtime'));
        $show->field('jobtime', __('Jobtime'));
        $show->field('achievement', __('Achievement'));
        $show->field('intentionmethod', __('Intentionmethod'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Talent);
        $form->ignore(['keyword','indetails']);
        $form->text('name', '姓名');
        $form->radio('sex', '性别')->options(TalentEnum::getSexes())->default('男');
        $form->text('jobtitle', '工作单位及职务');
        $form->datetime('birthday', '出生日期')->default(date('Y-m-d'))->format('YYYY-MM-DD');
        $form->text('nationality', '国籍');
        $form->text('major', '目前的专业/技术特长');
        $form->multipleSelect('teches','应用领域')->options(BaseCategory::selectOptions(null,'',7));
        $form->cascade('indetails','行业明细');
        if($form->isEditing()){
            $id = last(explode('/',str_replace('/edit','',url()->current())));
            $form->tags('keyword', '搜索关键词')->default(Talent::find($id)->keyword);
        }else {
            $form->tags('keyword', '搜索关键词');
        }
        $form->textarea('introduce', '个人简介');
        $form->text('university', '毕业院校与专业');
        $form->text('education', '学历学位');
        $form->text('studyabroad', '是否有留学经历（备注留学时间、学校及专业）');
        $form->textarea('gainhonor', '获得荣誉');
        $form->text('linkphone', '联系电话');
        $form->email('email', '邮箱');
        $form->text('longorshort', '任职情况（长期留驻、短期合作）');
        $form->text('remark', '备注');
        $form->datetime('luyangtime', '来庐阳工作时间')->default(date('Y-m-d H:i:s'));
        $form->datetime('jobtime', '与单位签订合同时间')->default(date('Y-m-d H:i:s'));
        $form->textarea('achievement', '成果');
        $form->textarea('intentionmethod', '合作意向方式');

        $form->saved(function (Form $form){
            $talent = $form->model();
            $store = DB::table('t_base_store')->where('store_code','talents')->first();
            $indetails = request('indetails');
            if($indetails){
                //$storePolicy->indetails()->delete();
                DB::table('t_store_store_category')->where(['record_id' => $talent->talents_id,'store_id' => $store->store_id])->delete();
                $indetails = explode(',',$indetails);
                foreach ($indetails as $indetail){
                    DB::table('t_store_store_category')->insert(['record_id' => $talent->talents_id,'store_id' => $store->store_id,'category_id' => $indetail]);
                }
            }

            $kewords = request('keyword');
            if($kewords){
                //$storePolicy->keywords()->delete();
                DB::table('t_store_store_keywords')->where(['record_id' => $talent->talents_id,'store_id' => $store->store_id])->delete();
                $kewords = explode(',',$kewords);
                foreach ($kewords as $keword){
                    $baseKeywords = BaseKeywords::where('keywords_name',$keword)->first();
                    if(!$baseKeywords) {
                        $baseKeywords = BaseKeywords::create(['keywords_name' => $keword]);
                    }
                    DB::table('t_store_store_keywords')->insert(['record_id' => $talent->talents_id,'keywords_id' => $baseKeywords->keywords_id,'store_id' => $store->store_id]);
                }
            }
        });

        return $form;
    }
}
