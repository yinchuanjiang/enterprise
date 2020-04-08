<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrResume extends Model
{
    protected $table = 't_hr_resume';
    protected $primaryKey = 'resume_id';
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function jobs()
    {
        return $this->belongsToMany(HrJob::class,'t_hr_job_record','resume_id','job_id');
    }
}
