<?php

namespace App\Admin\Actions\Policy;

use App\Models\StorePolicyUser;
use Encore\Admin\Actions\BatchAction;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class Push extends BatchAction
{

    protected $selector = '.import-post';

    public function handle(Collection $collection, Request $request)
    {
        $userIds = $request->input('user_id');
        if(!count($collection)){
            return $this->response()->error('请选择政策！！')->refresh();
        }
        if(!$userIds)
            return $this->response()->error('请选择推送用户！！')->refresh();
        $userIds = explode(',',$userIds);
        $data = [];
        foreach ($collection as $model) {
            foreach ($userIds as $id){
                $push = StorePolicyUser::where(['policy_id' => $model->policy_id,'user_id' => $id])->first();
                if($push)
                    continue;
                $data[] = [
                    'user_id' => $id,
                    'policy_id' => $model->policy_id,
                    'created_at' => now()->toDateTimeString(),
                    'updated_at' => now()->toDateTimeString(),
                ];
            }
        }
        if($data)
            DB::table('t_store_policy_users')->insert($data);
        return $this->response()->success('推送完成！')->refresh();
    }

    public function form()
    {
        $this->radio('xx','选择用户')->options([]);
        $this->hidden('user_id');
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-danger import-post"><i class="fa fa-location-arrow"></i>推送</a>
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