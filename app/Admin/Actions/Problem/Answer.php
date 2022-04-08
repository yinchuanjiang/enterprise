<?php

namespace App\Admin\Actions\Problem;

use App\Models\Enum\UserEnum;
use App\Models\StoreCompany;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Answer extends RowAction
{
    public $name = '回答';
    public function href()
    {
        return "/admin/problems/".$this->getKey()."/edit";
    }
}
