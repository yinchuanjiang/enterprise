<?php

namespace App\Models\Enum;


class HrResumeEnum
{
    const SEX_MALE = 1;//男
    const SEX_FEMALE = 2;//女

    /**
     * @param $hidden
     * @return string
     */
    public static function getSexName($sex)
    {
        switch ($sex){
            case self::SEX_MALE:
                return '男';
            case self::SEX_FEMALE:
                return '女';
            default:
                return '女';
        }
    }

    /**
     * @return array
     */
    public static function getSexes()
    {
        return [
            self::SEX_MALE => '男',
            self::SEX_FEMALE => '女',
        ];
    }
}
