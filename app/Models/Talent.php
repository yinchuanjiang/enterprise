<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Talent extends Model
{
    protected $table = 't_store_talents';
    protected $primaryKey = 'talents_id';
    public $timestamps = false;
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teches()
    {
        return $this->belongsToMany(BaseCategory::class,'t_store_talents_tech','talents_id','category_id');
    }

    //关联行业明细
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function indetails()
    {
        $store = DB::table('t_base_store')->where('store_code','talents')->first();
        return $this->belongsToMany(BaseCategory::class,'t_store_store_category','record_id','category_id')->wherePivot('store_id',$store->store_id);
    }

    //关联关键词
    public function keywords()
    {
        $store = DB::table('t_base_store')->where('store_code','talents')->first();
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
