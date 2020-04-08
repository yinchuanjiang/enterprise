<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseParameter extends Model
{
    protected $table = 't_base_parameter';
    protected $primaryKey = 'type_id';
    protected $guarded = [];
    public $timestamps = false;
}
