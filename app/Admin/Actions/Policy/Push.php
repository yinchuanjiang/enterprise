<?php

namespace App\Admin\Actions\Policy;

use App\Models\Enum\UserEnum;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Push extends RowAction
{
    public $name = '推送';

    public function handle(Model $model)
    {
        // $model ...

        return $this->response()->success('Success message.')->refresh();
    }

    public function form()
    {
        $type = [
            1 => '推送未发送的人',
        ];
        $this->checkbox('type', '类型')->options($type);
        $this->checkbox('user_id','推送用户')->options(UserEnum::getListBoxUsers());
    }

}