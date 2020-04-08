<?php

namespace App\Models\Enum;


use App\Models\BaseParameter;

class BaseParameterEnum
{
    const POLICY_TYPE = 'PolicyType';
    const KNOWLEDGE_TYPE = 'KnowLedgeType';
    const COMPANYREQ_TYPE = 'CompanyReqType';
    const ESTATE_TYPE = 'ESTATE_TYPE';
    const ESTATE_FIXTRUE = 'Fixture_Type';
    const AFFAIRS_TYPE = 'AffairsType';
    const PROBLEM_TYPE = 'Problem_Type';

    /**
     * @return mixed
     */
    public static function getListPolicyCategories()
    {
        return BaseParameter::where('para_type_name',self::POLICY_TYPE)->get()->map(function ($item,$key){
            return [
                'id' => $item->type_id,
                'name' => $item->type_value
            ];
        })->pluck('name','id')->all();
    }

    /**
     * @return mixed
     */
    public static function getListKnowledgeCategories()
    {
        return BaseParameter::where('para_type_name',self::KNOWLEDGE_TYPE)->get()->map(function ($item,$key){
            return [
                'id' => $item->type_id,
                'name' => $item->type_value
            ];
        })->pluck('name','id')->all();
    }

    /**
     * @return mixed
     */
    public static function getListCompanyRequirmentCategories()
    {
        return BaseParameter::where('para_type_name',self::COMPANYREQ_TYPE)->get()->map(function ($item,$key){
            return [
                'id' => $item->type_id,
                'name' => $item->type_value
            ];
        })->pluck('name','id')->all();
    }

    /**
     * @return mixed
     */
    public static function getListEstateTypes()
    {
        return BaseParameter::where('para_type_name',self::ESTATE_TYPE)->get()->map(function ($item,$key){
            return [
                'id' => $item->type_id,
                'name' => $item->type_value
            ];
        })->pluck('name','id')->all();
    }


    /**
     * @return mixed
     */
    public static function getListEstateFixtrues()
    {
        return BaseParameter::where('para_type_name',self::ESTATE_FIXTRUE)->get()->map(function ($item,$key){
            return [
                'id' => $item->type_id,
                'name' => $item->type_value
            ];
        })->pluck('name','id')->all();
    }

    /**
     * @return mixed
     */
    public static function getListAffairTypes()
    {
        return BaseParameter::where('para_type_name',self::AFFAIRS_TYPE)->get()->map(function ($item,$key){
            return [
                'id' => $item->type_id,
                'name' => $item->type_value
            ];
        })->pluck('name','id')->all();
    }
}
