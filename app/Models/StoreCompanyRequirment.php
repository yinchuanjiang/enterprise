<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreCompanyRequirment extends Model
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

}
