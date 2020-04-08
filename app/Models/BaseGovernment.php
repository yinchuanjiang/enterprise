<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseGovernment extends Model
{
    protected $table = 't_base_government';
    protected $primaryKey = 'government_id';
    protected $guarded = [];
    public $timestamps = false;
}
