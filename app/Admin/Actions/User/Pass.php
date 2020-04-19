<?php

namespace App\Admin\Actions\User;

use App\Models\Enum\UserEnum;
use App\Models\StoreCompany;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Pass extends RowAction
{
    public $name = '审核通过';

    public function handle(Model $model)
    {
        // $model ...
        $type = request('type');
        if ($type == 2) {
            $company_id = request('company_id');
            if (!$company_id)
                return $this->response()->error('请选择企业.');
        } else {
            $company_name = $model->user_realname;
            $company_nature = '企业';
            $company = StoreCompany::create(compact('company_name','company_nature'));
            $company_id = $company->company_id;
        }
        $user_id = $model->user_id;
        $has = DB::table('t_store_company_user')->where(compact('user_id', 'company_id'))->first();
        if (!$has)
            DB::table('t_store_company_user')->insert(compact('user_id', 'company_id'));
        $store = DB::table('t_base_store')->where('store_code','company')->first();
        $indetail = DB::table('t_user_field')->where(compact('user_id'))->first();
        DB::table('t_store_store_category')->insert(['record_id' => $company_id,'store_id' => $store->store_id,'category_id' => $indetail->field_id]);
        $model->status = UserEnum::STATUS_PASS;
        $model->save();
        return $this->response()->success('审核通过成功.')->refresh();
    }

    public function form()
    {
        $type = [
            1 => '创建新企业',
            2 => '选择企业'
        ];
        $companys = Cache::remember('select-companys', 5, function () {
            return StoreCompany::select('company_name', 'company_id')->pluck('company_name', 'company_id');
        });


        $this->radio('type', '创建企业？')->options($type)->required()->default(1);
        $this->select('company_id', '企业')->options($companys);
    }

}