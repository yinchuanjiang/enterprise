<?php

namespace App\Admin\Controllers;

use App\Admin\Export\TransupgradeExporter;
use App\Models\Transupgrade;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TransupgradeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '转型升级管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Transupgrade);
        $grid->column('tu_id', 'ID');
        $grid->column('name', '联系人');
        $grid->column('phone', '联系方式');
        $grid->column('content', '需求内容');
        $grid->column('user.user_name', '发起人')->label('success');
        $grid->column('create_time', '创建时间');
        //$grid->disableCreateButton();
        $grid->exporter(new TransupgradeExporter());
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
        $show = new Show(Transupgrade::findOrFail($id));

        $show->field('tu_id', __('Tu id'));
        $show->field('name', __('Name'));
        $show->field('phone', __('Phone'));
        $show->field('content', __('Content'));
        $show->field('create_time', __('Create time'));
        $show->field('user_id', __('User id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Transupgrade);

        $form->text('name', '联系人');
        $form->mobile('phone', '联系方式');
        $form->text('content', '需求内容');
        return $form;
    }
}
