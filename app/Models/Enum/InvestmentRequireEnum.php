<?php

namespace App\Models\Enum;


class InvestmentRequireEnum
{
    const TYPE_PERSON = 3;//消费类型 3个人消费 1企业消费 2其它消费
    const TYPE_COMPANY = 1;//
    const TYPE_OTHER = 2;//

    /**
     * @param $type
     * @return string
     */
    public static function getConstTypeName($type)
    {
        switch ($type){
            case self::TYPE_PERSON:
                return '个人消费';
            case self::TYPE_COMPANY:
                return '企业消费';
            case self::TYPE_OTHER:
                return '其它消费';
            default:
                return '个人消费';
        }
    }

    /**
     * @return array
     */
    public static function getConstTypes()
    {
        return [
            self::TYPE_PERSON => '个人消费',
            self::TYPE_COMPANY => '企业消费',
            self::TYPE_OTHER => '其它消费',
        ];
    }
}
