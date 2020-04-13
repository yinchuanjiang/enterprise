<?php

namespace App\Admin\Actions\Policy;

use App\Models\StorePolicyUser;
use App\Models\User;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PushPoint extends BatchAction
{

    protected $selector = '.push-point';

    public function handle(Collection $collection)
    {
        $data = [];
        foreach ($collection as $model) {
            $ids = StorePolicyUser::where('policy_id', $model->policy_id)->pluck('user_id')->toArray();
            $userIds = User::whereNotIn('user_id',$ids)->pluck('user_id')->toArray();
            foreach ($userIds as $id) {
                $data[] = [
                    'user_id' => $id,
                    'policy_id' => $model->policy_id,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ];
            }
        }
        if ($data)
            DB::table('t_store_policy_users')->insert($data);
        return $this->response()->success('推送完成！')->refresh();
    }

    public function dialog()
    {
        $this->confirm('确定推送吗？');
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-success push-point"><i class="fa fa-location-arrow"></i>给未推送的人推送</a>
HTML;
    }


    /**
     * {@inheritdoc}
     */
    public function actionScript()
    {
        $warning = '请选择政策！';

        return <<<SCRIPT
        var key = $.admin.grid.selected();
        
        if (key.length === 0) {
            $.admin.toastr.warning('{$warning}', '', {positionClass: 'toast-top-center'});
            return ;
        }
        
        Object.assign(data, {_key:key});
SCRIPT;
    }

}