<?php

namespace App\Models;

use App\Models\Enum\BaseParameterEnum;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    protected $table = 't_problem';
    protected $primaryKey = 'problem_id';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','user_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(BaseParameter::class,'problem_type_id','type_id')->where('para_type_name',BaseParameterEnum::PROBLEM_TYPE);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function answerer()
    {
        return $this->belongsTo(AdminUser::class,'answer_user_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function checker()
    {
        return $this->belongsTo(AdminUser::class,'check_user_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function records()
    {
        return $this->hasMany(ProblemRecord::class,'problem_id','problem_id');
    }



}
