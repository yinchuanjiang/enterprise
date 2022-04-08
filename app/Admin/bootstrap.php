<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use App\Admin\Extensions\Form\UEditor;
use App\Admin\Extensions\Form\NewUEditor;
use Encore\Admin\Form;

Form::forget(['map']);
Admin::js('vendor/laravel-admin-ext/cascade/bootstrap-treeview.min.js');
Admin::js('js/admin.js');
Admin::js('js/axios.min.js');
Admin::css('vendor/laravel-admin-ext/cascade/bootstrap-treeview.min.css');
//Form::extend('editor', UEditor::class);
Form::extend('neditor', NewUEditor::class);
Form::extend('tags', \App\Admin\Extensions\Form\Tags::class);
Form::extend('teches', \App\Admin\Extensions\Form\Teches::class);

Form::extend('cascade', \App\Admin\Extensions\csp\cascade\src\CascadeTreeView::class);
