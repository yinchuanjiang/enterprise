<?php
/**
 * Created by PhpStorm.
 * User: chenshaoping
 * Date: 2019/2/10
 * Time: 10:02
 */

namespace App\Admin\Extensions\csp\cascade\src;


use App\Models\BaseCategory;
use App\Models\CompanyRequirment;
use App\Models\Newtechproduct;
use App\Models\StoreCompany;
use App\Models\StoreKnowledge;
use App\Models\StorePolicy;
use App\Models\Talent;
use Encore\Admin\Form\Field;
use Illuminate\Support\Facades\DB;

class CascadeTreeView extends Field
{

    protected static $css = [
        '/vendor/laravel-admin-ext/cascade/bootstrap-treeview.min.css'
    ];
    protected static $js = [
        '/vendor/laravel-admin-ext/cascade/bootstrap-treeview.min.js'
    ];
    protected $view = 'admin.cascade.cascade';

    public function render()
    {
        /** @var StorePolicy $policy */
        $model = $this->form->model();
        if ($model instanceof StorePolicy) {
            if ($model->policy_id) {
                $store = DB::table('t_base_store')->where('store_code', 'policy')->first();
                $nodeIds = DB::table('t_store_store_category')->where(['record_id' => $model->policy_id, 'store_id' => $store->store_id])->pluck('category_id')->toArray();
            } else {
                $nodeIds = [];
                $names = [];
            }
        }
        if ($model instanceof StoreCompany) {
            if ($model->company_id) {
                $store = DB::table('t_base_store')->where('store_code', 'company')->first();
                $nodeIds = DB::table('t_store_store_category')->where(['record_id' => $model->company_id, 'store_id' => $store->store_id])->pluck('category_id')->toArray();
            } else {
                $nodeIds = [];
                $names = [];
            }
        }

        if ($model instanceof StoreKnowledge) {
            if ($model->knowledge_id) {
                $store = DB::table('t_base_store')->where('store_code', 'knowledge')->first();
                $nodeIds = DB::table('t_store_store_category')->where(['record_id' => $model->knowledge_id, 'store_id' => $store->store_id])->pluck('category_id')->toArray();
            } else {
                $nodeIds = [];
                $names = [];
            }
        }

        if ($model instanceof Newtechproduct) {
            if ($model->ntp_id) {
                $store = DB::table('t_base_store')->where('store_code', 'newtechproduct')->first();
                $nodeIds = DB::table('t_store_store_category')->where(['record_id' => $model->ntp_id, 'store_id' => $store->store_id])->pluck('category_id')->toArray();
            } else {
                $nodeIds = [];
                $names = [];
            }
        }

        if ($model instanceof Talent) {
            if ($model->talents_id) {
                $store = DB::table('t_base_store')->where('store_code', 'talents')->first();
                $nodeIds = DB::table('t_store_store_category')->where(['record_id' => $model->talents_id, 'store_id' => $store->store_id])->pluck('category_id')->toArray();
            } else {
                $nodeIds = [];
                $names = [];
            }
        }

        if ($model instanceof CompanyRequirment) {
            if ($model->req_id) {
                $store = DB::table('t_base_store')->where('store_code', 'requirment')->first();
                $nodeIds = DB::table('t_store_store_category')->where(['record_id' => $model->req_id, 'store_id' => $store->store_id])->pluck('category_id')->toArray();
            } else {
                $nodeIds = [];
                $names = [];
            }
        }

        if($nodeIds){
            $names = BaseCategory::whereIn('category_id', $nodeIds)->pluck('category_name')->toArray();
            $categoryKeywords = BaseCategory::whereIn('category_id', $nodeIds)->pluck('keywords')->toArray();
            $categoryKeywordsTrue = BaseCategory::whereIn('category_id', $nodeIds)->whereNotNull('keywords')->pluck('keywords')->toArray();

        }else{
            $categoryKeywords = [];
            $categoryKeywordsTrue = [];
        }

        $baseCategories = (new BaseCategory())->toNewTree(1, $nodeIds);
        $baseCategories = json_encode($baseCategories);
        $baseCategories = str_replace('category_name', 'text', $baseCategories);
        $baseCategories = str_replace('category_id', 'id', $baseCategories);
        $nodeIds = json_encode($nodeIds);
        $names = json_encode($names);
        $categoryKeywords = json_encode($categoryKeywords);
        $categoryKeywordsTrue = json_encode($categoryKeywordsTrue);
        $this->script = <<<EOT
var set = new Set();
var selected = new Set();
var key = new Set();
var nodeIds = $nodeIds;
var names = $names;
var categoryKeywords = $categoryKeywords;
var categoryKeywordsTrue = $categoryKeywordsTrue;
for(let i=0;i<nodeIds.length;i++){
    set.add(nodeIds[i]);
    selected.add(names[i]);
    if(typeof(categoryKeywords[i]) === 'string'){
        key.add(categoryKeywords[i]);
    }    
}
$('#checkable-output').text(Array.from(names).toString())
$('#keywords-output').text(Array.from(new Set(Array.from(categoryKeywordsTrue).toString().split(","))).toString())
var tree = $baseCategories;
$('#csp-bootstrap-tree').treeview({
    data: tree, 
    showIcon: false,
    showCheckbox: true,
    showTags:true,
    onNodeChecked: function(event, node) {
        set.add(node.id);
        selected.add(node.text)
        console.log(node.keywords)
        if(typeof(node.keywords) == 'string'){
            key.add(node.keywords)
        }
        console.log(key);
        console.log(set)
        $('#{$this->id}').val(Array.from(set));
        $('#checkable-output').text(Array.from(selected).toString())
        $('#keywords-output').text(Array.from(new Set(Array.from(key).toString().split(","))).toString())
    },
    onNodeUnchecked: function (event, node) {
        set.delete(node.id);
        console.log(set)
        selected.delete(node.text)
        if(node.keywords){
            //key.delete(node.keywords)
        }
        $('#{$this->id}').val(Array.from(set));
        $('#checkable-output').text(Array.from(selected).toString())
        //$('#keywords-output').text(Array.from(new Set(Array.from(key).toString().split(","))).toString())
    }
});
EOT;
//        $('#csp-bootstrap-tree').treeview('checkNode', [ $nodeIds, { silent: true } ]);
        return parent::render();
    }
}