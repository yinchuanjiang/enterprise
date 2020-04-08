<?php

namespace App\Models\Enum;


use App\Models\BaseGovernment;

class BaseGovernmentEnum
{
    const LEVEL_COUNTRY = 0;//机构级别 0国家 1省 2市 3区
    const LEVEL_PROVINCE = 1; //机构级别 0国家 1省 2市 3区
    const LEVEL_CITY = 2; //机构级别 0国家 1省 2市 3区
    const LEVEL_AREA = 3; //机构级别 0国家 1省 2市 3区

    /**
     * @return array
     */
    public static function getLevels()
    {
        return [
            self::LEVEL_COUNTRY => '国家',
            self::LEVEL_PROVINCE => '省',
            self::LEVEL_CITY => '市',
            self::LEVEL_AREA => '区'
        ];
    }

    /**
     * @param $level
     * @return string
     */
    public static function getLevelName($level)
    {
        switch ($level){
            case self::LEVEL_COUNTRY:
                return '国家';
            case self::LEVEL_PROVINCE:
                return '省';
            case self::LEVEL_CITY:
                return '市';
            case self::LEVEL_AREA:
                return '区';
            default:
                return '国家';
        }
    }


    public static function getListBoxGovernments()
    {
        return BaseGovernment::all()->map(function ($item,$key){
            return [
                'id' => $item->government_id,
                'name' => self::getLevelName($item->level).'==>'.$item->government_name
            ];
        })->pluck('name','id')->all();
    }

}
