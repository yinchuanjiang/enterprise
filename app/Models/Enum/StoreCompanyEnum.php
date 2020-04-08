<?php

namespace App\Models\Enum;


use App\Models\StoreCompany;

class StoreCompanyEnum
{
    const IS_HIGH_TRUE = 1;//是否高新 1是 2非
    const IS_HIGH_FALSE = 2;

    /**
     * @param $isHigh
     * @return string
     */
    public static function getIsHighName($isHigh)
    {
        switch ($isHigh) {
            case self::IS_HIGH_TRUE:
                return '是';
            case self::IS_HIGH_FALSE:
                return '不是';
            default:
                return '是';
        }
    }


    /**
     * @return array
     */
    public static function getIsHighs()
    {
        return [
            self::IS_HIGH_TRUE => '是',
            self::IS_HIGH_FALSE => '不是',
        ];
    }

    /**
     * @return array
     */
    public static function getCompanyScopes()
    {
        return [
            '企业' => '企业',
            '事业单位' => '事业单位',
            '社会团体' => '社会团体',
            '个体工商户' => '个体工商户',
            '民办非企业  ' => '民办非企业',
        ];
    }

    public static function getCompanies()
    {
        return StoreCompany::all()->map(function ($item,$key){
            return [
                'id' => $item->company_id,
                'name' => $item->company_id.'===>'.$item->company_name,
            ];
        })->pluck('name','id')->all();
    }
}
