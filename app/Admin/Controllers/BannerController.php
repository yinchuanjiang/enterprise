<?php

namespace App\Admin\Controllers;

use App\Models\Banner;
use App\Models\BannerCategory;
use App\Models\Enum\BannerEnum;
use App\Models\Enum\GoodEnum;
use App\Models\Goods;
use App\Models\Label;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'banner图管理';



    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Banner);

        $grid->column('banner_id', __('Id'));
        $grid->column('image_url', '图片')->display(function ($url) {
            return '<img src="/uploads/' . $url . '" style="max-width:30px;max-height:200px" ajax-url="'.$url.'" class="img img-thumbnail preview-image">';
        });
        $grid->column('type', '展示位置')->display(function ($type) {
            return "<span class='label label-success'>" . BannerEnum::getTypeName($type) . "</span>";
        })->filter(BannerEnum::getTyps());
        $grid->column('status','状态')->switch(BannerEnum::getSwitchStatus());
        $grid->column('sort', '排序')->editable()->sortable();
        $grid->column('create_time', '创建时间');
        $grid->filter(function ($filter) {
            //去掉id搜索
            $filter->disableIdFilter();
            // 设置created_at字段的范围查询
            $filter->between('created_at', '创建日期')->datetime();
        });
        //禁用导出数据按钮
        $grid->disableExport();
        //关闭行操作 删除
        $grid->actions(function ($actions) {
            $actions->disableView();
        });
        //设置分页选择器选项
        $grid->perPages([10, 20, 30, 40, 50]);
        //图片预览弹窗js
        $this->script = <<<EOT
        $('body').on('click','.preview-image',function (e) {
        let url = $(this).attr('ajax-url');
        swal({
            width: '60%',
            imageUrl: '/uploads/'+url,
        });
    });
EOT;
        Admin::script($this->script);
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
        $show = new Show(Banner::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('banner_category_id', __('Banner category id'));
        $show->field('image_url', __('Image url'));
        $show->field('type', __('Type'));
        $show->field('jump_type', __('Jump type'));
        $show->field('jump_id', __('Jump id'));
        $show->field('content', __('Content'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Banner);
        $form->image('image_url', 'banner图片')->required()->uniqueName()->help('*建议图片长宽比 5:2 或者1000*400px');
        //$form->select('type', '显示位置')->options(BannerEnum::getTyps())->required()->default(BannerEnum::BANNER_TYPE_HOME);
        $form->hidden('type')->value(BannerEnum::BANNER_TYPE_HOME);
        $form->switch('status','状态')->states(BannerEnum::getSwitchStatus())->default(BannerEnum::STATUS_TRUE);
        $form->text('sort','排序')->setWidth(2,2)->default(0)->help('数字小排序靠前')->rules('numeric',[
            'numeric' => '排序必须是数字'
        ])->icon('fa-sort-numeric-asc');

        $form->footer(function ($footer) {
            // 去掉`重置`按钮
            $footer->disableReset();

            // 去掉`提交`按钮
            //$footer->disableSubmit();
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();
            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();
        });
        return $form;
    }
}
