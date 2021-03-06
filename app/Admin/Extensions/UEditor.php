<?php
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/3/8
 * Time: 上午12:08
 */
namespace App\Admin\Extensions\Form;

use Encore\Admin\Form\Field;

class UEditor extends Field
{
    // 定义视图
    protected static $css = [];

    // css资源
    protected static $js = [
        'vendor/ueditor/ueditor.config.js',
        'vendor/ueditor/ueditor.all.js',
        'vendor/ueditor/lang/zh-cn/zh-cn.js'
    ];

    // js资源
    protected $view = 'admin.form.ueditor';

    public function render()
    {
        $url = url(config('ueditor.route.name'));
        $this->script = <<<EOT
        window.UEDITOR_CONFIG.serverUrl = '$url'
        //解决第二次进入加载不出来的问题
        UE.delEditor("ueditor");
        // 默认id是ueditor
        var ue = UE.getEditor('ueditor', {
            // 自定义工具栏
       
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode: true,
            wordCount: false,
            imagePopup: false,
            autotypeset: {indent: true, imageBlockLine: 'center'}
        }); 
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });

EOT;
        return parent::render();
    }
}