<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 't_user';
    protected $primaryKey = 'user_id';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $guarded = [];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(BaseCategory::class,'user_sub_type','category_id');
    }

    /**
     * 用户关注的领域
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fields()
    {
        return $this->belongsToMany(BaseCategory::class,'t_user_field','user_id','field_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wechat()
    {
        return $this->hasOne(WechatBind::class,'user_id','user_id');
    }
}
