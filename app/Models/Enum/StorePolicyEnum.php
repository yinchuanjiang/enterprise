<?php

namespace App\Models\Enum;


class StorePolicyEnum
{
    const POLICY_TYPE_APPLY_NOTICE = 1;//政策类别 1 申报通告  2 政策培训 3政策解读 4 通知政策 5通知公告
    const POLICY_TYPE_TRAIN = 2;
    const POLICY_TYPE_DECODE = 3;
    const POLICY_TYPE_NOTICE = 4;
    const POLICY_TYPE_NOTIFY_NOTICE = 5;

    const DECLARE_FLAG_TRUE = 1;//申报标识 2非申报 1申报
    const DECLARE_FLAG_FALSE = 2;

    const AUDIT_STATUS_TRUE = 2;//审核状态 1未审核 2已审核
    const AUDIT_STATUS_FALSE = 1;
    /**
     * @return array
     */
    public static function getPolicyTypes()
    {
        return [
            self::POLICY_TYPE_APPLY_NOTICE => '申报通告',
            self::POLICY_TYPE_TRAIN => '政策培训',
            self::POLICY_TYPE_DECODE => '政策解读',
            self::POLICY_TYPE_NOTICE => '通知政策',
            self::POLICY_TYPE_NOTIFY_NOTICE => '通知公告',
        ];
    }

    /**
     * @return array
     */
    public static function getDeclareFlags()
    {
        return [
            self::DECLARE_FLAG_FALSE => '非申报',
            self::DECLARE_FLAG_TRUE => '申报',
        ];
    }

    /**
     * @param $declareFlag
     * @return string
     */
    public static function getDeclareFlagName($declareFlag)
    {
        switch ($declareFlag){
            case self::DECLARE_FLAG_FALSE:
                return '非申报';
            case self::DECLARE_FLAG_TRUE:
                return '申报';
            default:
                return '申报';
        }
    }

    /**
     * @param $type
     * @return string
     */
    public static function getModuleTypeName($type)
    {
        switch ($type){
            case self::POLICY_TYPE_APPLY_NOTICE:
                return '申报通告';
            case self::POLICY_TYPE_TRAIN:
                return '政策培训';
            case self::POLICY_TYPE_DECODE:
                return '政策解读';
            case self::POLICY_TYPE_NOTICE:
                return '通知政策';
            case self::POLICY_TYPE_NOTIFY_NOTICE:
                return '通知公告';
            default:
                return '申报通告';
        }
    }

    public static function getAuditStatusName($status)
    {
        switch ($status){
            case self::AUDIT_STATUS_TRUE:
                return '已审核';
            case self::AUDIT_STATUS_FALSE:
                return '未审核';
            default:
                return '未审核';
        }
    }

    /**
     * @return array
     */
    public static function getSwitchAuditStatus()
    {
        return [
            'on' => ['value' => self::AUDIT_STATUS_TRUE, 'text' => '已审核', 'color' => 'success'],
            'off' => ['value' => self::AUDIT_STATUS_FALSE, 'text' => '未审核', 'color' => 'danger'],
        ];
    }

}
