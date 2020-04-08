<?php

namespace App\Admin\Controllers;

use App\Models\Enum\HrResumeEnum;
use App\Models\HrResume;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HrResumeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '简历管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HrResume);

        $grid->column('resume_id', 'ID');
        $grid->column('name', '姓名');
        $grid->column('sex', '性别')->display(function ($sex){
            return HrResumeEnum::getSexName($sex);
        });
        $grid->column('mobile', '手机号');
        $grid->column('position', '职位');
        $grid->column('educational', '最高学历');
        $grid->column('create_time', '录入时间');
        $grid->disableExport();
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
        $show = new Show(HrResume::findOrFail($id));

        $show->field('resume_id', __('Resume id'));
        $show->field('user_id', __('User id'));
        $show->field('position', __('Position'));
        $show->field('name', __('Name'));
        $show->field('sex', __('Sex'));
        $show->field('birthday', __('Birthday'));
        $show->field('work_years', __('Work years'));
        $show->field('educational', __('Educational'));
        $show->field('mobile', __('Mobile'));
        $show->field('areacode', __('Areacode'));
        $show->field('resume_file', __('Resume file'));
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
        $form = new Form(new HrResume);

        $form->text('name', '姓名');
        $form->radio('sex', '性别')->options(HrResumeEnum::getSexes())->default(HrResumeEnum::SEX_MALE);
        $form->datetime('birthday', '生日')->default(date('Y-m-d H:i:s'))->format('YYYY-m-d');
        $form->text('position', '职位');
        $form->text('work_years', '工作年限');
        $form->text('educational', '最高学历');
        $form->mobile('mobile', '手机号');
        $form->text('areacode', '地区');
        $form->file('resume_file', '简历附件')->removable()->uniqueName();

        return $form;
    }
}
