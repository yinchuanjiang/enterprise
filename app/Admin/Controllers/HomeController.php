<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enum\UserEnum;
use App\Models\Problem;
use App\Models\StoreKnowledge;
use App\Models\StorePolicy;
use App\Models\User;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        //创业者数量
        $userOfPioneer = User::where('user_type',UserEnum::TYPE_PERSON)->count();
        //
        $userOfCompany = User::where('user_type',UserEnum::TYPE_COMPANY)->count();
        //
        $userOfGoverment = User::where('user_type',UserEnum::TYPE_GOVERMENT)->count();
        //政策总数
        $policyCount = StorePolicy::count();
        //知识产权数量
        $knowledgeCount = StoreKnowledge::count();
        //问题数量
        $problemCount = Problem::count();

        return $content
            ->title('首页')
            ->row(view('admin.home.index',compact('userOfPioneer','userOfCompany','userOfGoverment','policyCount','knowledgeCount','problemCount')));
//            ->row(function (Row $row) {
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::environment());
//                });
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::extensions());
//                });
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::dependencies());
//                });
//            });
    }
}
