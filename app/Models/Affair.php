<?php

namespace App\Models;

use App\Models\Enum\BaseParameterEnum;
use Illuminate\Database\Eloquent\Model;

class Affair extends Model
{
    protected $table = 't_affairs';
    protected $primaryKey = 'affairs_id';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(BaseParameter::class,'type_id','type_id')->where('para_type_name',BaseParameterEnum::AFFAIRS_TYPE);
    }
}
