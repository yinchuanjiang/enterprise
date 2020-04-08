<?php

namespace App\Models\Enum;


class UserEnum
{
    const TYPE_PERSON = 1;//用户类型 1个人 2企业 3机构
    const TYPE_COMPANY = 2;
    const TYPE_GOVERMENT = 3;

    const STATUS_PASS = 2; //状态 1未审核 2审核通过 3审核不通过
    const STATUS_NO_PASS = 3;
    const STATUS_TO_PASS = 1;

    /**
     * @param $type
     * @return string
     */
    public static function getTypeName($type)
    {
        switch ($type){
            case self::TYPE_PERSON:
                return '个人';
            case self::TYPE_COMPANY:
                return '企业';
            case self::TYPE_GOVERMENT:
                return '机构';
            default:
                return '机构';
        }
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::TYPE_PERSON => '个人',
            self::TYPE_COMPANY => '企业',
            self::TYPE_GOVERMENT => '机构',
        ];
    }

    /**
     * @param $status
     * @return string
     */
    public static function getStatusName($status)
    {
        switch ($status){
            case self::STATUS_TO_PASS:
                return '未审核';
            case self::STATUS_PASS:
                return '审核通过';
            case self::STATUS_NO_PASS:
                return '审核不通过';
            default:
                return '未审核';
        }
    }

    /**
     * @return array
     */
    public static function getStatus()
    {
        return [
            self::STATUS_TO_PASS => '未审核',
            self::STATUS_PASS => '审核通过',
            self::STATUS_NO_PASS => '审核不通过',
        ];
    }

    /**
     * @return array
     */
    public static function getSwitchStatus()
    {
        return [
            'on' => ['value' => self::STATUS_PASS, 'text' => '通过', 'color' => 'success'],
            'off' => ['value' => self::STATUS_NO_PASS, 'text' => '不通过', 'color' => 'danger'],
        ];
    }
}
