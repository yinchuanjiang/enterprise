<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestmentRequire extends Model
{
    protected $table = 't_investment_require';
    protected $primaryKey = 'require_id';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $guarded = [];
}
