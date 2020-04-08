<?php

namespace App\Admin\Controllers;

use App\Models\BaseCategory;
use App\Models\InvestmentProduct;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class InvestmentProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '投融服务管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new InvestmentProduct);

        $grid->column('investment_id', 'ID');
        $grid->column('loan_name', '贷款名称');
        $grid->column('category.category_name', '贷款类型')->label('info');
        $grid->column('loan_bank', '贷款银行')->width(350);
        $grid->column('businessobject', '业务对象');
        $grid->column('repay_method', '还款方式');
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
        $show = new Show(InvestmentProduct::findOrFail($id));

        $show->field('investment_id', __('Investment id'));
        $show->field('category_id', __('Category id'));
        $show->field('loan_name', __('Loan name'));
        $show->field('loan_bank', __('Loan bank'));
        $show->field('loan_pic', __('Loan pic'));
        $show->field('interest', __('Interest'));
        $show->field('principal', __('Principal'));
        $show->field('monthly', __('Monthly'));
        $show->field('quota', __('Quota'));
        $show->field('businessobject', __('Businessobject'));
        $show->field('repay_method', __('Repay method'));
        $show->field('repay_rate', __('Repay rate'));
        $show->field('lend_time', __('Lend time'));
        $show->field('product_introduce', __('Product introduce'));
        $show->field('requirements', __('Requirements'));
        $show->field('contact_name', __('Contact name'));
        $show->field('contact_phone', __('Contact phone'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new InvestmentProduct);

        $form->text('loan_name', '贷款名称');
        $form->select('category_id', '贷款类型')->options(BaseCategory::selectOptions(null,'',1291));
        $form->text('loan_bank', '贷款银行');
        $form->image('loan_pic', '贷款列表展示图片')->uniqueName()->removable();
        $form->text('interest', '利息总额');
        $form->text('principal', '本息总额');
        $form->text('monthly', '贷款月供');
        $form->text('quota', '额度范围');
        $form->text('businessobject', '业务对象');
        $form->text('repay_method', '还款方式');
        $form->text('repay_rate', '利率');
        $form->text('lend_time', '放款时间');
        $form->editor('product_introduce','产品介绍');
        $form->textarea('requirements', '申请条件');
        $form->text('contact_name', '联系人称呼');
        $form->text('contact_phone', '联系电话');

        return $form;
    }
}
