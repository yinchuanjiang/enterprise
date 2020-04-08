<?php

namespace App\Models\Enum;


use App\Models\AdminUser;

class AdminUserEnum
{
    public static function getAdminUsers()
    {
        return AdminUser::all()->pluck('username','id');
    }
}
