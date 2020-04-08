<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseKeywords extends Model
{
    protected $table = 't_base_keywords';
    protected $primaryKey = 'keywords_id';
    protected $guarded = [];
    public $timestamps = false;
}
