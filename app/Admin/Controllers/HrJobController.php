<?php

namespace App\Admin\Controllers;

use App\Models\HrJob;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HrJobController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '企业招聘管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HrJob);

        $grid->column('job_id', 'ID');
        $grid->column('job_title', '招聘标题');
        $grid->column('job_pay', '薪资');
        $grid->column('job_number', '招聘用户数');
        $grid->column('work_years', '工作年限');
        $grid->column('educational', '学历要求');
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
        $show = new Show(HrJob::findOrFail($id));

        $show->field('job_title', '招聘标题');
        $show->field('job_address', __('Job address'));
        $show->field('job_pay', '薪资');
        $show->field('job_number', '招聘人数');
        $show->field('work_time', '工作时间');
        $show->field('work_years', '工作年限');
        $show->field('welfare', __('Welfare'));
        $show->field('educational', __('Educational'));
        $show->field('description', __('Description'));
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
        $form = new Form(new HrJob);

        $form->text('job_title', '招聘标题');
        $form->text('job_pay', '薪资');
        $form->text('job_number', '招聘人数');
        $form->text('work_time', '工作时间');
        $form->text('work_years', '工作年限');
        $form->textarea('welfare', __('福利'));
        $form->text('educational', '学历要求');
        $form->textarea('description', '描述');
        $form->text('job_address', '工作地址');

        return $form;
    }
}
