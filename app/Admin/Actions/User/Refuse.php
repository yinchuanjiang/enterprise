<?php

namespace App\Admin\Actions\User;

use App\Models\Enum\UserEnum;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Refuse extends RowAction
{
    public $name = '拒绝';

    public function handle(Model $model)
    {
        // $model ...
        $model->status = UserEnum::STATUS_NO_PASS;
        $model->save();
        return $this->response()->success('拒绝成功.')->refresh();
    }

}