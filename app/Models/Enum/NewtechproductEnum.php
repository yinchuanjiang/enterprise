<?php

namespace App\Models\Enum;


class NewtechproductEnum
{
    const TYPE_NEW_TECH = 1;//分类 1 新技术 2 新产品
    const TYPE_NEW_PRODUCT = 2;

    /**
     * @param $type
     * @return string
     */
    public static function getTypeName($type)
    {
        switch ($type){
            case self::TYPE_NEW_TECH:
                return '新技术';
            case self::TYPE_NEW_PRODUCT:
                return '新产品';
            default:
                return '新技术';
        }
    }

    public static function getTypes()
    {
        return [
            self::TYPE_NEW_TECH => '新技术',
            self::TYPE_NEW_PRODUCT => '新产品',
        ];
    }
}
