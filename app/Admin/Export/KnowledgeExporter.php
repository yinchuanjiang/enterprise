<?php

/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2020/2/17
 * Time: 下午2:26
 */
namespace App\Admin\Export;

use App\Models\Enum\StoreKnowledgeEnum;
use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class KnowledgeExporter extends ExcelExporter implements WithMapping
{
    protected $fileName = '知识库.xlsx';

    protected $columns = [
        'knowledge_id'      => 'ID',
        'classify_id' => '知识库类别ID',
        'classify.type_value' => '知识库类别',
        'company_id' => '企业ID',
        'company.company_name' => '企业名称',
        'knowledge_name' => '名称',
        'knowledge_number'   => '编号',
        'knowledge_desc' => '专利介绍',
        'isauthorize' => '是否授权',
        'create_time' => '创建时间',
        'update_time' => '更新时间',
    ];

    public function map($knowledge) : array
    {
        return [
            $knowledge->knowledge_id,
            $knowledge->classify_id,
            data_get($knowledge, 'classify.type_value'),
            $knowledge->company_id,
            data_get($knowledge, 'company.company_name'),
            $knowledge->knowledge_name,
            $knowledge->knowledge_number,
            $knowledge->knowledge_desc,
            StoreKnowledgeEnum::getIsauthorizeName($knowledge->isauthorize),
            $knowledge->create_time,
            $knowledge->update_time,
        ];
    }


}