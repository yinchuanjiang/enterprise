<?php
namespace App\Models\Enum;
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/4/25
 * Time: 下午7:31
 */
class BannerEnum{
    //banner位置
    const BANNER_TYPE_HOME = 1;
    //const BANNER_TYPE_USER_CENTER = 2;
    // 状态
    const STATUS_TRUE = 1;
    const STATUS_FALSE = 2;


    /**
     * @param $type
     * @return string
     */
    public static function getTypeName($type){
        switch ($type){
            case self::BANNER_TYPE_HOME:
                return '首页';
            case self::BANNER_TYPE_USER_CENTER:
                return '个人中心页面';
            default:
                return '首页';
        }
    }

    /**
     * @return array
     */
    public static function getTyps()
    {
        return [
            self::BANNER_TYPE_HOME => '首页',
            //self::BANNER_TYPE_USER_CENTER => '个人中心页面'
        ];
    }

    /**
     * @return array
     */
    public static function getStatus()
    {
        return [
            self::STATUS_TRUE => '启动',
            self::STATUS_FALSE => '禁用',
        ];
    }

    /**
     * @return array
     */
    public static function getSwitchStatus()
    {
        return [
            'on' => ['value' => self::STATUS_TRUE, 'text' => '启用', 'color' => 'success'],
            'off' => ['value' => self::STATUS_FALSE, 'text' => '禁用', 'color' => 'danger'],
        ];
    }
}