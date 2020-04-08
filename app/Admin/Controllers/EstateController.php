<?php

namespace App\Admin\Controllers;

use App\Models\Enum\BaseParameterEnum;
use App\Models\Estate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EstateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '场地管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Estate);

        $grid->column('Estate_ID', 'ID');
        $grid->column('Estate_Name', '场地名称');
        $grid->column('type.type_value', '场地类型')->label('info');
        $grid->column('fixture.type_value', '装修类型')->label('success');
        $grid->column('Area', '面积(单位：平方）');
        $grid->column('Telephone', '联系电话');
        $grid->column('Pic_URL', '图片地址')->image('',30);
        $grid->column('Create_Time', '添加时间');
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
        $show = new Show(Estate::findOrFail($id));

        $show->field('Estate_ID', __('Estate ID'));
        $show->field('Estate_Name', __('Estate Name'));
        $show->field('Estate_Type_ID', __('Estate Type ID'));
        $show->field('Fixture_Type_ID', __('Fixture Type ID'));
        $show->field('Area', __('Area'));
        $show->field('Address', __('Address'));
        $show->field('Telephone', __('Telephone'));
        $show->field('Indroduce', __('Indroduce'));
        $show->field('Pic_URL', __('Pic URL'));
        $show->field('Create_Time', __('Create Time'));
        $show->field('Update_Time', __('Update Time'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Estate);

        $form->text('Estate_Name', '场地名称');
        $form->select('Estate_Type_ID', '场地类型')->options(BaseParameterEnum::getListEstateTypes());
        $form->select('Fixture_Type_ID', '装修类型')->options(BaseParameterEnum::getListEstateFixtrues());
        $form->number('Area', '面积(单位：平方）');
        $form->text('Address', '地址');
        $form->text('Telephone', '联系方式');
        $form->textarea('Indroduce', '介绍');
        $form->image('Pic_URL', '图片')->uniqueName()->removable();

        return $form;
    }
}
