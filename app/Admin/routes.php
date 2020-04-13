<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    //政策库
    $router->get('policies/keywords', 'PolicyController@keywords');
    $router->resource('policies', PolicyController::class);
    //行业明细管理
    $router->resource('categories', CategoryController::class);
    //发文单位管理
    $router->resource('governments', GovernmentController::class);
    //公司库管理
    $router->resource('companies', CompanyController::class);
    //知识库管理
    $router->resource('knowledges', KnowLedgeController::class);
    //新技术新产品库管理
    $router->resource('newtechproducts', NewtechproductController::class);
    //专家人才库管理
    $router->resource('talents', TalentController::class);
    //企业需求库管理
    $router->resource('company-requirments', CompanyRequirmentController::class);
    //新闻资讯中心管理
    $router->resource('news', NewsController::class);
    //创业服务--专业机构管理
    $router->resource('professionals', ProfessionalController::class);
    //创业服务--场地管理
    $router->resource('estates', EstateController::class);
    //创业服务--企业招聘
    $router->resource('hr-jobs', HrJobController::class);
    //创业服务--简历管理
    $router->resource('hr-resumes', HrResumeController::class);
    //办事大厅管理
    $router->resource('affairs', AffairController::class);
    //投融服务管理
    $router->resource('investment-products', InvestmentProductController::class);
    //投融服务需求管理
    $router->resource('investment-requires', InvestmentRequireController::class);
    //用户管理
    $router->get('/users/html', 'UserController@html');
    //个人用户
    $router->resource('users', UserController::class);
    //企业用户
    $router->resource('company-users', CompanyUserController::class);
    //机构用户
    $router->resource('goverment-users', GovermentUserController::class);
    //转型升级管理
    $router->resource('transupgrades', TransupgradeController::class);
    //问题流转管理
    $router->resource('problems', ProblemController::class);
    //意见反馈管理
    $router->resource('suggests', SuggestController::class);
    //banner图管理
    $router->resource('banners', BannerController::class);
});
