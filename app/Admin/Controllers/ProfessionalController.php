<?php

namespace App\Admin\Controllers;

use App\Models\BaseCategory;
use App\Models\Enum\ProfessionalEnum;
use App\Models\Professional;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProfessionalController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '专业机构管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Professional);

        $grid->column('piid', 'ID');
        $grid->column('Institution_Name', '服务机构名称');
        $grid->column('category.category_name', '服务机构类型')->label('info');
        $grid->column('Contact', '联系人');
        $grid->column('Telephone', '联系电话');
        $grid->column('Qrcode_URL', '二维码')->image('',30);
        $grid->column('is_hidden', '是否显示')->switch(ProfessionalEnum::getSwitchIsHiddenStatus());
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
        $show = new Show(Professional::findOrFail($id));

        $show->field('piid', __('Piid'));
        $show->field('Institution_Name', __('Institution Name'));
        $show->field('category_id', __('Category id'));
        $show->field('Contact', __('Contact'));
        $show->field('Telephone', __('Telephone'));
        $show->field('Introduce', __('Introduce'));
        $show->field('Qrcode_URL', __('Qrcode URL'));
        $show->field('is_hidden', __('Is hidden'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Professional);

        $form->text('Institution_Name', '服务机构名称');
        $form->select('category_id', '服务机构类型')->options(BaseCategory::selectOptions(null,'',1316));
        $form->text('Contact', '联系人');
        $form->text('Telephone', '联系电话');
        $form->textarea('Introduce', '机构介绍');
        $form->image('Qrcode_URL', '二维码')->uniqueName()->removable();
        $form->switch('is_hidden', '是否显示')->states(ProfessionalEnum::getSwitchIsHiddenStatus())->default(ProfessionalEnum::IS_HIDDEN_TRUE);
        return $form;
    }
}
