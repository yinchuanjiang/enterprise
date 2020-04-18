<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upgrade extends Model
{
    protected $table = 't_upgrade';
    protected $guarded = [];
    const CREATED_AT = 'create_time';
    const UPDATED_AT =  'update_time';
    protected $primaryKey = 'upgrade_id';
}
