<?php

/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2020/2/17
 * Time: 下午2:26
 */
namespace App\Admin\Export;

use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class CompanyRequirmentExporter extends ExcelExporter implements WithMapping
{
    protected $fileName = '企业需求.xlsx';

    protected $columns = [
        'req_id'      => 'ID',
        'company_id' => '公司ID',
        'company.company_name' => '企业名称',
        'req_type' => '需求类型ID',
        'type.type_value' => '需求类型',
        'req_tag'   => '需求标签',
        'req_content' => '需求内容',
        'contact_name' => '联系人',
        'contact_phone' => '联系方式',
        'create_time' => '创建时间',
        'update_time' => '更新时间',
    ];

    public function map($storeCompanyRequirment) : array
    {
        return [
            $storeCompanyRequirment->req_id,
            $storeCompanyRequirment->company_id,
            data_get($storeCompanyRequirment, 'company.company_name'),
            $storeCompanyRequirment->req_type,
            data_get($storeCompanyRequirment, 'type.type_value'),
            $storeCompanyRequirment->req_tag,
            $storeCompanyRequirment->req_content,
            $storeCompanyRequirment->contact_name,
            $storeCompanyRequirment->contact_phone,
            $storeCompanyRequirment->create_time,
            $storeCompanyRequirment->update_time,
        ];
    }


}