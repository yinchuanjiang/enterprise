<?php

/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2020/2/17
 * Time: 下午2:26
 */
namespace App\Admin\Export;

use App\Models\Enum\StoreCompanyEnum;
use App\Models\Enum\TalentEnum;
use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class TalentExporter extends ExcelExporter implements WithMapping
{
    protected $fileName = '专家人才库.xlsx';

    protected $columns = [
        'talents_id'      => 'ID',
        'name'   => '姓名',
        'sex' => '性别',
        'jobtitle' => '工作单位及职务',
        'birthday' => '出生年月',
        'nationality' => '国籍',
        'major' => '目前的专业/技术特长',
        'introduce' => '个人简介',
        'university' => '毕业院校与专业',
        'education' => '学历学位',
        'studyabroad' => '是否有留学经历（备注留学时间、学校及专业）',
        'gainhonor' => '获得荣誉',
        'linkphone' => '联系电话',
        'email' => '邮箱',
        'longorshort' => '任职情况（长期留驻、短期合作）',
        'luyangtime' => '来庐阳工作时间',
        'jobtime' => '与单位签订合同时间',
        'achievement' => '成果',
        'intentionmethod' => '合作意向方式',
        'remark' => '备注',
    ];

    public function map($talent) : array
    {

        return [
            $talent->talents_id,
            $talent->name,
            $talent->sex,
            $talent->jobtitle,
            $talent->birthday,
            $talent->nationality,
            $talent->major,
            $talent->introduce,
            $talent->university,
            $talent->education,
            $talent->studyabroad,
            $talent->gainhonor,
            $talent->linkphone,
            $talent->email,
            $talent->longorshort,
            $talent->luyangtime,
            $talent->jobtime,
            $talent->achievement,
            $talent->intentionmethod,
            $talent->remark,
        ];
    }


}