<?php

namespace App\Admin\Controllers;

use App\Models\Suggest;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SuggestController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '意见反馈管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Suggest);

        $grid->column('suggest_id', 'ID');
        $grid->column('user_name', '联系人');
        $grid->column('user_contact', '联系方式');
        $grid->column('content', '反馈内容');
        $grid->column('create_time', '反馈时间');
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
        $show = new Show(Suggest::findOrFail($id));

        $show->field('suggest_id', __('Suggest id'));
        $show->field('user_name', __('User name'));
        $show->field('user_contact', __('User contact'));
        $show->field('content', __('Content'));
        $show->field('create_time', __('Create time'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Suggest);

        $form->text('user_name', __('User name'));
        $form->text('user_contact', __('User contact'));
        $form->textarea('content', __('Content'));

        return $form;
    }
}
