<?php

namespace App\Admin\Controllers;

use App\Models\Affair;
use App\Models\Enum\BaseParameterEnum;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AffairController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '办事大厅管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Affair);

        $grid->column('affairs_id', 'ID');
        $grid->column('affairs_title', '标题')->filter('like');
        $grid->column('type.type_value', '类型')->label('info');
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
        $show = new Show(Affair::findOrFail($id));

        $show->field('affairs_id', __('Affairs id'));
        $show->field('affairs_title', __('Affairs title'));
        $show->field('affairs_content', __('Affairs content'));
        $show->field('type_id', __('Type id'));
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
        $form = new Form(new Affair);

        $form->text('affairs_title', '标题')->required();
        $form->select('type_id', '类型')->options(BaseParameterEnum::getListAffairTypes())->required();
        $form->editor('affairs_content', '内容');
        return $form;
    }
}
