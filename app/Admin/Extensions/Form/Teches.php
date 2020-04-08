<?php
/**
 * Created by PhpStorm.
 * User: yinchuanjiang
 * Date: 2019/12/20
 * Time: 下午5:28
 */
namespace App\Admin\Extensions\Form;


use App\Models\BaseCategory;
use App\Models\Talent;
use Encore\Admin\Form\Field;
use Illuminate\Support\Facades\DB;

class Teches extends Field
{
    protected $view = 'admin.form.teches';

    protected static $css = [
        '/vendor/laravel-admin-ext/cascade/bootstrap-treeview.min.css'
    ];
    protected static $js = [
        '/vendor/laravel-admin-ext/cascade/bootstrap-treeview.min.js'
    ];

    public function render()
    {
        /** @var Talent $talent */
        $talent = $this->form->model();
        if($talent->talents_id){
            $nodeIds = DB::table('t_store_talents_tech')->where('talents_id',$talent->talents_id)->pluck('category_id')->toArray();
            $names = BaseCategory::whereIn('category_id',$nodeIds)->pluck('category_name')->toArray();
        }else{
            $nodeIds = [];
            $names = [];
        }
        $baseCategories = (new BaseCategory())->toNewTree(7,$nodeIds);
        $baseCategories = json_encode($baseCategories);
        $baseCategories = str_replace('category_name','text',$baseCategories);
        $baseCategories = str_replace('category_id','id',$baseCategories);
        $nodeIds = json_encode($nodeIds);
        $names = json_encode($names);
        $this->script = <<<EOT
var set = new Set();
var selected = new Set();
var nodeIds = $nodeIds;
var names = $names;
for(let i=0;i<nodeIds.length;i++){
    set.add(nodeIds[i]);
    selected.add(names[i]);
}
$('#checkable-output').text(Array.from(names).toString())
var tree = $baseCategories;
$('#csp-bootstrap-tree').treeview({
    data: tree, 
    showIcon: false,
    showCheckbox: true,
    showTags:true,
    onNodeChecked: function(event, node) {
        set.add(node.id);
        selected.add(node.text)
        console.log(set)
        $('#{$this->id}').val(Array.from(set));
        $('#checkable-output').text(Array.from(selected).toString())
    },
    onNodeUnchecked: function (event, node) {
        set.delete(node.id);
        console.log(set)
        selected.delete(node.text)
        $('#{$this->id}').val(Array.from(set));
        $('#checkable-output').text(Array.from(selected).toString())
    }
});
EOT;
//        $('#csp-bootstrap-tree').treeview('checkNode', [ $nodeIds, { silent: true } ]);
        return parent::render();
    }
}