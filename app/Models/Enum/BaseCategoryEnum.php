<?php

namespace App\Models\Enum;


use App\Models\BaseCategory;

class BaseCategoryEnum
{
    /**
     * @return mixed
     */
    public static function getListBoxIndetails()
    {
        $ids = BaseCategory::where('parent_id',1)->pluck('category_id')->toArray();
        $ids = BaseCategory::whereIn('parent_id',$ids)->pluck('category_id');
        return BaseCategory::whereIn('category_id',$ids)->get()->map(function ($item,$key){
            return [
                'id' => $item->category_id,
                'name' => $item->parent->category_name.'==>'.$item->category_name
            ];
        })->pluck('name','id')->all();
    }

}
