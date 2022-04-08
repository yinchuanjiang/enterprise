<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Problem\BatchCheck;
use App\Admin\Actions\Problem\BatchPoint;
use App\Models\Enum\ProblemEnum;
use App\Models\Problem;
use App\Models\ProblemRecord;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Admin;

class ProblemController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '问题流转管理';


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Problem);
        if (Admin::user()->isRole('manger') || Admin::user()->isRole('administrator')){
            $grid->model()->orderBy('problem_id','desc');
        }else{
            if(Admin::user()->isRole('answer')){
                $grid->model()->where('answer_user_id',Admin::user()->id)->orderBy('problem_id','desc');
            }
            if(Admin::user()->isRole('check')){
                $grid->model()->where('check_user_id',Admin::user()->id)->orderBy('problem_id','desc');
            }
        }

        $grid->column('problem_id', 'ID');
        $grid->column('user.user_realname', '发起人');
        $grid->column('telephone', '联系方式');
        $grid->column('type.type_value', '问题类型')->label('info');
        $grid->column('problem_title', '标题');
        $grid->column('answerer.username', '处理人')->label('info');
        $grid->column('checker.username', '审核人')->label('info');
        $grid->column('status', '状态')->display(function ($status){
            return ProblemEnum::getStatusName($status);
        })->label([
            ProblemEnum::STATUS_TODO => 'danger',
            ProblemEnum::STATUS_PASS_TO_PREFECTURAL => 'warning',
            ProblemEnum::STATUS_CHECK => 'info',
            ProblemEnum::STATUS_DONE => 'success',
        ]);
        $grid->column('is_hot','是否热门')->switch(ProblemEnum::getSwitchStatus());
        $grid->column('create_time', '创建时间');

        $grid->tools(function (Grid\Tools $tools) {
            if (Admin::user()->isRole('manger') || Admin::user()->isRole('administrator')){
                $tools->append(new BatchPoint());
            }
            if(Admin::user()->isRole('check') || Admin::user()->isRole('administrator')){
                $tools->append(new BatchCheck());
            }
        });
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            // 去掉查看
            $actions->disableView();
        });
        $this->script = <<<EOT
        $('.column-__actions__').hide();
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
        $show = new Show(Problem::findOrFail($id));

        $show->field('problem_id', __('Problem id'));
        $show->field('user_id', __('User id'));
        $show->field('company_name', __('Company name'));
        $show->field('telephone', __('Telephone'));
        $show->field('problem_type_id', __('Problem type id'));
        $show->field('problem_title', __('Problem title'));
        $show->field('content', __('Content'));
        $show->field('source_url', __('Source url'));
        $show->field('pic_url', __('Pic url'));
        $show->field('others', __('Others'));
        $show->field('answer', __('Answer'));
        $show->field('answer_time', __('Answer time'));
        $show->field('create_time', __('Create time'));
        $show->field('update_time', __('Update time'));
        $show->field('status', __('Status'));

        return $show;
    }

    public function edit($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description('回复')
            ->body($this->form()->edit($id));
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Problem);

        $form->text('company_name', '企业名称')->readonly();
        $form->text('telephone', '联系方式')->readonly();
        $form->text('problem_title', '问题标题')->readonly();
        $form->textarea('content', '问题内容')->readonly();
        $form->text('source_url', '问题来源')->readonly();
        $form->text('others', __('其它说明'))->readonly();
        $form->switch('is_hot','是否热门')->states(ProblemEnum::getSwitchStatus())->default(ProblemEnum::HOT_FALSE);
        $form->textarea('answer', '回答');
        $form->saved(function (Form $form){
            $problem = $form->model();
            if($problem->answer_user_id == Admin::user()->id && $problem->answer && $problem->status == ProblemEnum::STATUS_PASS_TO_PREFECTURAL){
                $problem->status = ProblemEnum::STATUS_CHECK;
                $problem->save();
                $record = new ProblemRecord([
                    'admiin_id' => $problem->check_user_id,
                    'action' => ProblemEnum::STATUS_CHECK,
                ]);
                $problem->records()->save($record);
            }
        });
        return $form;
    }
}
