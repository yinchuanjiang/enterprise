<?php

/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2020/2/17
 * Time: 下午2:26
 */
namespace App\Admin\Export;

use App\Models\Enum\NewtechproductEnum;
use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class NewtechproductsExporter extends ExcelExporter implements WithMapping
{
    protected $fileName = '新技术新产品库.xlsx';

    protected $columns = [
        'ntp_id'      => 'ID',
        'ntp_type'   => '分类',
        'ntp_name' => '成果名称',
        'ntp_holder' => '项目持有人',
        'ntp_case' => '运用案例与运用场景',
        'ntp_stage' => '所处阶段',
        'contact_name' => '联系人',
        'contact_tel' => '联系电话',
        'keywords' => '关键字',
        //'ntp_content' => '成果内容',
        'create_time' => '创建时间',
        'update_time' => '更新时间',
    ];

    public function map($newtechproducts) : array
    {

        return [
            $newtechproducts->ntp_id,
            NewtechproductEnum::getTypeName($newtechproducts->ntp_type),
            $newtechproducts->ntp_name,
            $newtechproducts->ntp_holder,
            $newtechproducts->ntp_case,
            $newtechproducts->ntp_stage,
            $newtechproducts->contact_name,
            $newtechproducts->contact_tel,
            $newtechproducts->keywords,
            //$newtechproducts->ntp_content,
            $newtechproducts->create_time,
            $newtechproducts->update_time,
        ];
    }


}