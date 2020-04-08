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

class TransupgradeExporter extends ExcelExporter implements WithMapping
{
    protected $fileName = '转型升级.xlsx';

    protected $columns = [
        'tu_id'      => 'ID',
        'name'   => '联系人',
        'phone' => '手机号码',
        'user_id' => '发起人ID',
        'user.user_name' => '发起人',
        'content' => '内容',
        'create_time' => '创建时间',
    ];

    public function map($transupgrade) : array
    {

        return [
            $transupgrade->tu_id,
            $transupgrade->name,
            $transupgrade->phone,
            $transupgrade->user_id,
            data_get($transupgrade, 'user.user_name'),
            $transupgrade->content,
            $transupgrade->create_time,
        ];
    }


}