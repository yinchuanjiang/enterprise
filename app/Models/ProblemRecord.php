<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProblemRecord extends Model
{
    protected $table = 't_problem_record';
    protected $primaryKey = 'record_id';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = NULL;
    protected $guarded = [];


}
