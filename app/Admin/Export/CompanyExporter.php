<?php

/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2020/2/17
 * Time: 下午2:26
 */
namespace App\Admin\Export;

use App\Models\Enum\StoreCompanyEnum;
use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class CompanyExporter extends ExcelExporter implements WithMapping
{
    protected $fileName = '企业库.xlsx';

    protected $columns = [
        'company_id'      => 'ID',
        'company_name'   => '企业名称',
        'company_introduction' => '企业介绍',
        'company_address' => '企业地址',
        'company_nature' => '企业性质',
        'is_high' => '是否高新',
        'register_time' => '注册时间',
        'register_money' => '注册资本',
        'register_address' => '注册地址',
        'corporation_name' => '法人姓名',
        'corporation_call' => '法人称呼',
        'corporation_phone' => '法人电话',
        'contact_name' => '联系人姓名',
        'contact_tell' => '联系人固话',
        'contact_phone' => '联系人手机',
        'contact_email' => '联系人电子邮箱',
        'staff_number_total' => '员工数量',
        'staff_number_college' => '专科数量',
        'staff_number_bachelor' => '本科数量',
        'staff_number_master' => '硕士数量',
        'staff_number_returnee' => '海归数量',
        'create_time' => '创建时间',
        'update_time' => '更新时间',
    ];

    public function map($storeCompany) : array
    {

        return [
            $storeCompany->company_id,
            $storeCompany->company_name,
            $storeCompany->company_introduction,
            $storeCompany->company_address,
            $storeCompany->company_nature,
            StoreCompanyEnum::getIsHighName($storeCompany->is_high),
            $storeCompany->register_time,
            $storeCompany->register_money,
            $storeCompany->register_address,
            $storeCompany->corporation_name,
            $storeCompany->corporation_call,
            $storeCompany->corporation_phone,
            $storeCompany->contact_name,
            $storeCompany->contact_tell,
            $storeCompany->contact_phone,
            $storeCompany->contact_email,
            $storeCompany->staff_number_total,
            $storeCompany->staff_number_college,
            $storeCompany->staff_number_bachelor,
            $storeCompany->staff_number_master,
            $storeCompany->staff_number_returnee,
            $storeCompany->create_time,
            $storeCompany->update_time,
        ];
    }


}