<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestmentProduct extends Model
{
    protected $table = 't_investment_product';
    protected $primaryKey = 'investment_id';
    public $timestamps = false;
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(BaseCategory::class,'category_id','category_id');
    }
}
