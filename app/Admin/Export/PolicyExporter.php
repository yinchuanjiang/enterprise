<?php

/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2020/2/17
 * Time: 下午2:26
 */
namespace App\Admin\Export;

use App\Models\Enum\StorePolicyEnum;
use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class PolicyExporter extends ExcelExporter implements WithMapping
{
    protected $fileName = '政策库.xlsx';

    protected $columns = [
        'policy_id'      => 'ID',
        'policy_title'   => '标题',
        'policy_description' => '政策摘要',
        'policy_author' => '政策作者',
        'policy_label' => '政策标签',
        'policy_range' => '政策范围',
        'module_type' => '功能类别',
        'start_time' => '开始时间',
        'end_time' => '结束时间',
        'source_url' => '来源网址',
        'publish_date' => '发布日期',
        'declare_flag' => '申报标识',
        'declare_title' => '申报主题',
        'declare_units' => '申报单位',
        'declare_requirement' => '申报条件',
        'declare_range' => '申报范围',
        'declare_subsidy' => '补贴额度',
        'declare_contact' => '联系方式',
        'declare_deadline' => '截止时间',
        'audit_status' => '审核状态',
        'views' => '浏览次数',
        'create_time' => '创建时间',
        'update_time' => '更新时间',
    ];

    public function map($storePolicy) : array
    {

        return [
            $storePolicy->policy_id,
            $storePolicy->policy_title,
            $storePolicy->policy_description,
            $storePolicy->policy_author,
            $storePolicy->policy_label,
            $storePolicy->policy_range,
            StorePolicyEnum::getModuleTypeName($storePolicy->module_type),
            $storePolicy->start_time,
            $storePolicy->end_time,
            $storePolicy->source_url,
            $storePolicy->publish_date,
            StorePolicyEnum::getDeclareFlagName($storePolicy->declare_flag),
            $storePolicy->declare_title,
            $storePolicy->declare_units,
            $storePolicy->declare_requirement,
            $storePolicy->declare_range,
            $storePolicy->declare_subsidy,
            $storePolicy->declare_contact,
            $storePolicy->declare_deadline,
            StorePolicyEnum::getAuditStatusName($storePolicy->audit_status),
            $storePolicy->views,
            $storePolicy->create_time,
            $storePolicy->update_time,
        ];
    }


}