<?php

namespace App\Models;

use App\Models\Enum\BaseParameterEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CompanyRequirment extends Model
{
    protected $table = 't_store_company_requirment';
    protected $primaryKey = 'req_id';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teches()
    {
        return $this->belongsToMany(BaseCategory::class,'t_store_company_requirment_tech','req_id','category_id');
    }

    public function company()
    {
        return $this->belongsTo(StoreCompany::class,'company_id','company_id');
    }

    public function type()
    {
        return $this->belongsTo(BaseParameter::class,'req_type','type_id')->where('para_type_name',BaseParameterEnum::COMPANYREQ_TYPE);
    }

    //关联行业明细
    public function indetails()
    {
        $store = DB::table('t_base_store')->where('store_code','requirment')->first();
        return $this->belongsToMany(BaseCategory::class,'t_store_store_category','record_id','category_id')->wherePivot('store_id',$store->store_id);
    }

    //关联关键词
    public function keywords()
    {
        $store = DB::table('t_base_store')->where('store_code','requirment')->first();
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
