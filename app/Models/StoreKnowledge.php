<?php

namespace App\Models;

use App\Models\Enum\BaseParameterEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StoreKnowledge extends Model
{
    protected $table = 't_store_knowledge';
    protected $primaryKey = 'knowledge_id';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(StoreCompany::class,'company_id','company_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classify()
    {
        return $this->belongsTo(BaseParameter::class,'classify_id','type_id')->where('para_type_name',BaseParameterEnum::KNOWLEDGE_TYPE);
    }

    //关联行业明细
    public function indetails()
    {
        $store = DB::table('t_base_store')->where('store_code','knowledge')->first();
        return $this->belongsToMany(BaseCategory::class,'t_store_store_category','record_id','category_id')->wherePivot('store_id',$store->store_id);
    }

    //关联关键词
    public function keywords()
    {
        $store = DB::table('t_base_store')->where('store_code','knowledge')->first();
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
