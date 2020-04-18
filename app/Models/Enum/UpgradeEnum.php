<?php
namespace App\Models\Enum;
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/4/25
 * Time: 下午7:31
 */
class UpgradeEnum{
    //banner位置
    // 状态
    const TYPE_ANDROID = 1;//Android
    const TYPE_IOS = 2;


    /**
     * @param $type
     * @return string
     */
    public static function getTypeName($type){
        switch ($type){
            case self::TYPE_ANDROID:
                return '安卓';
            case self::TYPE_IOS:
                return '苹果';
            default:
                return '苹果';
        }
    }

    /**
     * @return array
     */
    public static function getTyps()
    {
        return [
            self::TYPE_ANDROID => '安卓',
            self::TYPE_IOS => '苹果',
        ];
    }
}