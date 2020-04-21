<?php

namespace App\Admin\Actions\Policy;

use App\Models\StorePolicyUser;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class PushType extends RowAction
{
    public $name = '给未推送的人推送';

    public function handle(Model $model)
    {
        $data = [];
        $ids = StorePolicyUser::where('policy_id', $model->policy_id)->pluck('user_id')->toArray();
        $userIds = User::whereNotIn('user_id', $ids)->pluck('user_id')->toArray();
        foreach ($userIds as $id) {
            $data[] = [
                'user_id' => $id,
                'policy_id' => $model->policy_id,
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ];
        }
        if ($data)
            DB::table('t_store_policy_users')->insert($data);
        return $this->response()->success('推送完成！')->refresh();

    }

}