<?php

namespace App\Admin\Controllers;

use App\Models\Enum\UserEnum;
use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CompanyUserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '企业用户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);
        $grid->model()->where('user_type',UserEnum::TYPE_COMPANY);
        $grid->column('user_id', 'ID');
        $grid->column('user_name', '账号')->filter('like');
        $grid->column('user_realname', '用户姓名')->filter('like');
        $grid->column('mobile', '手机号')->filter('like');
//        $grid->column('user_type','用户类型')->display(function ($type){
//            return UserEnum::getTypeName($type);
//        })->label('info')->filter(UserEnum::getTypes());
        $grid->column('fields', '关注热点')->pluck('category_name')->label('success');
        $grid->column('category.category_name', '用户子类型')->label('success');
        $grid->column('business_license_pic', '营业执照图片');
        $grid->column('wechat', '绑定微信信息')->display(function ($wechat){
            if(!$wechat){
                return '<span class="label label-danger">未绑定</span>';
            }else{
                return '<span class="label label-success">已绑定</span>';
            }
        });
        $grid->column('status', '状态')->filter(UserEnum::getStatus())->radio(UserEnum::getStatus());
        $grid->column('create_time', '注册时间');
        $grid->disableExport();
        $grid->actions(function ($actions) {
            // 去掉查看
            $actions->disableView();
            $actions->disableEdit();
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
        $show = new Show(User::findOrFail($id));

        $show->field('user_id', __('User id'));
        $show->field('user_passwd', __('User passwd'));
        $show->field('user_realname', __('User realname'));
        $show->field('user_name', __('User name'));
        $show->field('mobile', __('Mobile'));
        $show->field('user_type', __('User type'));
        $show->field('business_license_pic', __('Business license pic'));
        $show->field('user_sub_type', __('User sub type'));
        $show->field('status', __('Status'));
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
        $form = new Form(new User);

        $form->number('user_realname', __('User realname'));
        $form->number('user_name', __('User name'));
        $form->mobile('mobile', __('Mobile'));
        $form->number('user_type', __('User type'));
        $form->text('business_license_pic', __('Business license pic'));
        $form->number('user_sub_type', __('User sub type'));
        $form->number('status', __('Status'));

        return $form;
    }
}
