<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatBind extends Model
{
    protected $table = 't_wechat_bind';
    protected $primaryKey = 'openid';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $guarded = [];

}
