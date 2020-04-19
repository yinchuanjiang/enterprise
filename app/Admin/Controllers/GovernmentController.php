<?php

namespace App\Admin\Controllers;

use App\Models\BaseGovernment;
use App\Models\Enum\BaseGovernmentEnum;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GovernmentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '发文单位管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BaseGovernment);

        $grid->column('government_id', 'Id');
        $grid->column('government_name', '政府机构名称')->filter('like');
        $grid->column('level', '机构级别')->display(function ($level){
            return BaseGovernmentEnum::getLevelName($level);
        })->label('success')->filter(BaseGovernmentEnum::getLevels());
        $grid->disableExport();
        $grid->actions(function ($actions) {
            // 去掉查看
            $actions->disableView();
        });
        $grid->disableBatchActions();
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
        $show = new Show(BaseGovernment::findOrFail($id));

        $show->field('government_id', __('Government id'));
        $show->field('government_name', __('Government name'));
        $show->field('level', __('Level'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new BaseGovernment);

        $form->text('government_name', '政府机构名称')->required();
        $form->radio('level', '机构级别')->options(BaseGovernmentEnum::getLevels())->default(BaseGovernmentEnum::LEVEL_COUNTRY)->required();

        return $form;
    }


    public function destroy($id)
    {
        $baseGovernment = BaseGovernment::find($id);
        //TODO 数据是否被使用

//        $has = $baseGovernment;
//        if($has){
//            return response()->json([
//                'status'  => false,
//                'message' => '请先移除下级',
//            ]);
//        }
        return $this->form()->destroy($id);
    }
}
