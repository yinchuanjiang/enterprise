<?php

namespace App\Admin\Controllers;

use App\Models\BaseCategory;
use Encore\Admin\Facades\Admin;
use Illuminate\Routing\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;

class CategoryController extends Controller
{
    use HasResourceActions;
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '行业明细管理';

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        $this->script = <<<EOT
        setTimeout(function () {
            $('.dd').nestable('collapseAll');
        },1000)
EOT;
        Admin::script($this->script);
        return $content
            ->title($this->title)
            ->description(trans('admin.list'))

            ->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());
                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_url('categories'));
                    $form->select('parent_id', '上级名称')->options(BaseCategory::selectOptions());
                    $form->text('category_name', '名称')->rules('required');
                    $form->tags('keywords','关键词');
                    $form->hidden('_token')->default(csrf_token());
                    $column->append((new Box(trans('admin.new'), $form))->style('success'));
                });
            });
    }

    /**
     * @return \Encore\Admin\Tree
     */
    protected function treeView()
    {

        return BaseCategory::tree(function (Tree $tree) {
            $tree->disableCreate();
            $tree->branch(function ($branch) {
                $payload = "&nbsp;<strong>{$branch['category_name']}</strong>";
                return $payload;
            });
        });
    }

    /**
     * Redirect to edit page.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        return redirect()->route('admin.auth.menu.edit', ['id' => $id]);
    }

    /**
     * Edit interface.
     *
     * @param string $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->title(trans('admin.menu'))
            ->description(trans('admin.edit'))
            ->row($this->form()->edit($id));
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {

        $form = new Form(new BaseCategory());

        $form->display('category_id', 'ID');

        $form->select('parent_id', trans('admin.parent_id'))->options(BaseCategory::selectOptions());
        $form->text('category_name', '名称')->rules('required');
        $form->tags('keywords','关键词');
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


        $form->saving(function (Form $form) {

        });
        return $form;
    }

    public function destroy($id)
    {
        $baseCategory = BaseCategory::find($id);
        //TODO 该部门是否有员工  该部门是否有订单

        $has = BaseCategory::where('parent_id',$baseCategory->category_id)->count();
        if($has){
            return response()->json([
                'status'  => false,
                'message' => '请先移除下级',
            ]);
        }
        return $this->form()->destroy($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->form()->update($id);
        $url = url()->previous();
        admin_toastr(trans('admin.save_succeeded'));
        return redirect($url);
    }

}
