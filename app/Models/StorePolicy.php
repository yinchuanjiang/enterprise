<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StorePolicy extends Model
{
    protected $table = 't_store_policy';
    protected $primaryKey = 'policy_id';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $guarded = [];
    
    
    //关联政策库类别
    public function categories()
    {
        return $this->belongsToMany(BaseParameter::class,'t_store_policy_pocategory','policy_id','policy_category_id');
    }

    //关联发文单位
    public function governments()
    {
        return $this->belongsToMany(BaseGovernment::class,'t_store_policy_government','policy_id','government_id');
    }

    //关联行业明细
    public function indetails()
    {
        $store = DB::table('t_base_store')->where('store_code','policy')->first();
        return $this->belongsToMany(BaseCategory::class,'t_store_store_category','record_id','category_id')->wherePivot('store_id',$store->store_id);
    }

    //关联关键词
    public function keywords()
    {
        $store = DB::table('t_base_store')->where('store_code','policy')->first();
        return $this->belongsToMany(BaseKeywords::class,'t_store_store_keywords','record_id','keywords_id')->wherePivot('store_id',$store->store_id);
    }

    /**
     * @return string
     */
    public function getKeywordAttribute()
    {
        return implode(',',$this->keywords->pluck('keywords_name')->toArray());
    }
}
