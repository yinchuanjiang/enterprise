<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggest extends Model
{
    protected $table = 't_suggest';
    protected $primaryKey = 'suggest_id';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = NULL;
    protected $guarded = [];
}
