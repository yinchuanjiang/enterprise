<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StoreCompany extends Model
{
    protected $table = 't_store_company';
    protected $primaryKey = 'company_id';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function governments()
    {
        return $this->belongsToMany(BaseGovernment::class,'t_store_company_government','company_id','government_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fielddetails()
    {
        $store = DB::table('t_base_store')->where('store_code','company')->first();
        return $this->belongsToMany(BaseCategory::class,'t_store_store_category','record_id','category_id')->wherePivot('store_id',$store->store_id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function policycategories()
    {
        return $this->belongsToMany(BaseParameter::class,'t_store_company_policycategory','company_id','policy_category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requirments()
    {
        return $this->hasMany(StoreCompanyRequirment::class,'company_id','company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function keywords()
    {
        $store = DB::table('t_base_store')->where('store_code','company')->first();
        return $this->belongsToMany(BaseKeywords::class,'t_store_store_keywords','record_id','keywords_id')->wherePivot('store_id',$store->store_id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class,'t_store_company_user','company_id','user_id');
    }

    /**
     * @return string
     */
    public function getKeywordAttribute()
    {
        return implode(',',$this->keywords->pluck('keywords_name')->toArray());
    }

}
