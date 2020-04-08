<?php

namespace App\Admin\Actions\Problem;

use App\Models\Enum\AdminUserEnum;
use App\Models\Enum\ProblemEnum;
use App\Models\ProblemRecord;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class BatchPoint extends BatchAction
{
    protected $selector = '.point-problem';

    public function handle(Collection $collection,Request $request)
    {
        $answer_user_id = $request->get('answer_user_id');
        $check_user_id = $request->get('check_user_id');
        $status = ProblemEnum::STATUS_PASS_TO_PREFECTURAL;
        foreach ($collection as $model) {
            if($model->status != ProblemEnum::STATUS_TODO)
                continue;
            $model->update(compact('answer_user_id','check_user_id','status'));
            $record = new ProblemRecord([
                'admiin_id' => $model->check_user_id,
                'action' => $status,
            ]);
            $model->records()->save($record);
        }

        return $this->response()->success('指派问题成功')->refresh();
    }

    public function form()
    {
        $this->select('answer_user_id', '处理人')->options(AdminUserEnum::getAdminUsers())->required();
        $this->select('check_user_id', '审核人')->options(AdminUserEnum::getAdminUsers())->required();
    }

    public function html()
    {
        return "<a class='point-problem btn btn-sm btn-danger'><i class='fa fa-hand-o-right'></i>指派问题</a>";
    }

}