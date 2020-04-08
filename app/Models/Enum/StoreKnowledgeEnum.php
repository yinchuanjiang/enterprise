<?php

namespace App\Models\Enum;


class StoreKnowledgeEnum
{
    const ISAUTHORIZE_TRUE = 1;//是否授权 2未授权 1已授权
    const ISAUTHORIZE_FALSE = 2;

    /**
     * @param $isauthorize
     * @return string
     */
    public static function getIsauthorizeName($isauthorize)
    {
        switch ($isauthorize){
            case self::ISAUTHORIZE_TRUE:
                return '已授权';
            case self::ISAUTHORIZE_FALSE:
                return '未授权';
            default:
                return '未授权';
        }
    }

    public static function getIsauthorizes()
    {
        return [
            self::ISAUTHORIZE_FALSE => '未授权',
            self::ISAUTHORIZE_TRUE => '已授权',
        ];
    }
}
