<?php

namespace App\Admin\Actions\Problem;

use App\Models\Enum\ProblemEnum;
use App\Models\ProblemRecord;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class BatchCheck extends BatchAction
{

    protected $selector = '.check-problem';

    public function handle(Collection $collection,Request $request)
    {
        $status = $request->get('status');
        foreach ($collection as $model) {
            if($model->status != ProblemEnum::STATUS_CHECK)
                continue;
            $model->status =  $status;
            $model->save();
            $record = new ProblemRecord([
                'admiin_id' => $model->answer_user_id,
                'action' => $status,
            ]);
            $model->records()->save($record);
        }
        return $this->response()->success('审核问题成功')->refresh();
    }


    public function form()
    {
        $this->radio('status', '审核')->options([ProblemEnum::STATUS_DONE => '通过'])->default(ProblemEnum::STATUS_DONE);
    }

    public function html()
    {
        return "<a class='check-problem btn btn-sm btn-success'><i class='fa fa-check'></i>审核问题</a>";
    }

}