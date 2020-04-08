<?php

namespace App\Models\Enum;


class ProfessionalEnum
{
    const IS_HIDDEN_TRUE = 1;//显示
    const IS_HIDDEN_FALSE = 2;//不显示

    /**
     * @param $hidden
     * @return string
     */
    public static function getTypeName($hidden)
    {
        switch ($hidden){
            case self::IS_HIDDEN_TRUE:
                return '显示';
            case self::IS_HIDDEN_FALSE:
                return '不显示';
            default:
                return '不显示';
        }
    }

    /**
     * @return array
     */
    public static function getIsHiddens()
    {
        return [
            self::IS_HIDDEN_TRUE => '显示',
            self::IS_HIDDEN_FALSE => '不显示',
        ];
    }

    /**
     * @return array
     */
    public static function getSwitchIsHiddenStatus()
    {
        return [
            'on' => ['value' => self::IS_HIDDEN_TRUE, 'text' => '显示', 'color' => 'success'],
            'off' => ['value' => self::IS_HIDDEN_FALSE, 'text' => '不显示', 'color' => 'danger'],
        ];
    }
}
