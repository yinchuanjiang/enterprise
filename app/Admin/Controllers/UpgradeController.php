<?php

namespace App\Admin\Controllers;

use App\Models\Enum\UpgradeEnum;
use App\Models\Upgrade;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UpgradeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '版本更新管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Upgrade());

        $grid->column('upgrade_id', 'Id');
        $grid->column('version', '版本号')->filter('like');
        $grid->column('device_type', '客户端类型')->display(function ($type){
            return UpgradeEnum::getTypeName($type);
        })->label('success')->filter(UpgradeEnum::getTyps());
        $grid->column('download_url', '下载地址');
        $grid->column('create_time', '添加时间');
        $grid->disableFilter();
        //禁用导出数据按
        $grid->disableExport();
        //关闭行操作 删除
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        //设置分页选择器选项
        $grid->perPages([10, 20, 30, 40, 50]);
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
        $show = new Show(Upgrade::findOrFail($id));

        $show->field('upgrade_id', __('Upgrade id'));
        $show->field('version', __('Version'));
        $show->field('desc', __('Desc'));
        $show->field('device_type', __('Device type'));
        $show->field('download_url', __('Download url'));
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
        $form = new Form(new Upgrade());

        $form->text('version', '版本号')->required();
        $form->select('device_type', '客户端类型')->options(UpgradeEnum::getTyps())->required();
        $form->textarea('desc', '更新说明');
        $form->text('download_url', '下载地址');

        return $form;
    }
}
