<?php

namespace App\Models\Enum;


class ProblemEnum
{
    const STATUS_TODO = 1;//问题状态 1待处理  2已受理(管理人员受理) 3处理中(管理人员指派客服) 4已完成(客服处理完成，给客户发消息)
    const STATUS_PASS_TO_PREFECTURAL = 2;
    const STATUS_CHECK = 3;
    const STATUS_DONE = 4;

    const HOT_TRUE = 1;
    const HOT_FALSE = -1;

    /**
     * @param $status
     * @return string
     */
    public static function getStatusName($status)
    {
        switch ($status){
            case self::STATUS_TODO:
                return '待处理';
            case self::STATUS_PASS_TO_PREFECTURAL:
                return '处理中';
            case self::STATUS_CHECK:
                return '审核中';
            case self::STATUS_DONE:
                return '已完成';
            default:
                return '待处理';
        }
    }

    /**
     * @return array
     */
    public static function getStatus()
    {
        return [
            self::STATUS_TODO => '待处理',
            self::STATUS_PASS_TO_PREFECTURAL => '处理中',
            self::STATUS_CHECK => '审核中',
            self::STATUS_DONE => '已完成',
        ];
    }

    /**
     * @return array
     */
    public static function getSwitchStatus()
    {
        return [
            'on' => ['value' => self::HOT_TRUE, 'text' => '是', 'color' => 'success'],
            'off' => ['value' => self::HOT_FALSE, 'text' => '否', 'color' => 'danger'],
        ];
    }
}
