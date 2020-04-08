<?php
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/12/20
 * Time: 下午5:28
 */
namespace App\Admin\Extensions\Form;


use Encore\Admin\Form\Field;

class Tags extends Field
{
    protected $view = 'admin.form.tags';

    protected static $css = [
        'https://cdn.bootcss.com/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css',
    ];


    protected static $js = [
        'https://cdn.bootcss.com/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js',
    ];

    public function render()
    {
        $this->script = "$(\"{$this->getElementClassSelector()} \").tagsinput();";
        return parent::render();
    }
}