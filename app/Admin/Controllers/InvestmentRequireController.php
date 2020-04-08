<?php

namespace App\Admin\Controllers;

use App\Models\Enum\InvestmentRequireEnum;
use App\Models\InvestmentRequire;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class InvestmentRequireController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '投融服务需求管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new InvestmentRequire);

        $grid->column('require_id', 'ID');
        $grid->column('apply_name', '申请人名称');
        $grid->column('apply_phone', '联系方式');
        $grid->column('cost_type', '消费类型')->display(function ($type){
            return InvestmentRequireEnum::getConstTypeName($type);
        })->label('info')->filter(InvestmentRequireEnum::getConstTypes());
        $grid->column('loan_amount', '贷款金额');
        $grid->column('loan_term', '贷款期限');
        $grid->column('create_time', '申请时间');
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
        $show = new Show(InvestmentRequire::findOrFail($id));

        $show->field('require_id', __('Require id'));
        $show->field('apply_name', __('Apply name'));
        $show->field('apply_phone', __('Apply phone'));
        $show->field('cost_type', __('Cost type'));
        $show->field('loan_amount', __('Loan amount'));
        $show->field('loan_term', __('Loan term'));
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
        $form = new Form(new InvestmentRequire);

        $form->text('apply_name', '申请人名称')->required();
        $form->text('apply_phone', '联系方式')->required();
        $form->radio('cost_type', '消费类型')->options(InvestmentRequireEnum::getConstTypes())->default(InvestmentRequireEnum::TYPE_PERSON)->required();
        $form->text('loan_amount', '贷款金额（元）')->required();
        $form->text('loan_term', '贷款期限')->required();

        return $form;
    }
}
