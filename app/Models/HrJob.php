<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrJob extends Model
{
    protected $table = 't_hr_job';
    protected $primaryKey = 'job_id';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function resumes()
    {
        return $this->belongsToMany(HrResume::class,'t_hr_job_record','job_id','resume_id');
    }
}
