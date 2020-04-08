<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transupgrade extends Model
{
    protected $table = 't_transupgrade';
    protected $primaryKey = 'tu_id';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = NULL;
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','user_id');
    }
}
