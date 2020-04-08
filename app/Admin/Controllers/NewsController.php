<?php

namespace App\Admin\Controllers;

use App\Models\BaseCategory;
use App\Models\News;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NewsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '新闻资讯中心管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new News);

        $grid->column('news_id', 'ID');
        $grid->column('category.category_name', '栏目')->label('info');
        $grid->column('news_title', '标题')->filter('like');
        $grid->column('news_author', '作者')->filter('like');
        $grid->column('create_time', '创建时间');
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
        $show = new Show(News::findOrFail($id));

        $show->field('news_id', __('News id'));
        $show->field('news_title', __('News title'));
        $show->field('news_content', __('News content'));
        $show->field('news_author', __('News author'));
        $show->field('source_name', __('Source name'));
        $show->field('source_url', __('Source url'));
        $show->field('category_id', __('Category id'));
        $show->field('pic_url', __('Pic url'));
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
        $form = new Form(new News);

        $form->text('news_title', '标题')->required();
        $form->text('news_author', '作者');
        $form->select('category_id', '新闻栏目')->options(BaseCategory::selectOptions(null,'',1310));
        $form->editor('news_content', '内容');
        $form->text('source_name', '来源网站名称');
        $form->text('source_url', '来源网站地址');
        $form->image('pic_url', '图片展示');

        return $form;
    }
}
