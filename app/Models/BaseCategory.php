<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Support\Facades\DB;

class BaseCategory extends Model
{
    use AdminBuilder, ModelTree {
        ModelTree::boot as treeBoot;
    }
    public $timestamps = false;
    protected $table = 't_base_category';
    protected $primaryKey = 'category_id';
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTitleColumn('category_name');
        //$this->setParentColumn('parent_id');
        //$this->setOrderColumn('order');
    }

    /*
    * return array
    */

    public function allSonId($id)
    {
        $ids = $this->getAllSonsIds($id) ?: [];
        array_push($ids, $id);
        return $ids;
    }

    /*
     * 返回包括自身在内的子部门
     */

    public function getAllSonsIds($id)
    {
        static $depts = [];
        $dept = $this->get()->toArray();
        foreach ($dept as $d) {
            if ($d['parent_id'] === intval($id)) {
                $depts[] = $d['category_id'];
                $this->getAllSonsIds($d['category_id']);
            }
        }
        return $depts;
    }

    /**
     * Format data to tree like array.
     *
     * @return array
     */
    public function toNewTree($parentId = 0,$defaultSelect = [])
    {
        return $this->buildNewNestedArray([], $parentId,$defaultSelect);
    }

    /**
     * Build Nested array.
     *
     * @param array $nodes
     * @param int $parentId
     *
     * @return array
     */
    protected function buildNewNestedArray(array $nodes = [], $parentId = 0,$defaultSelect)
    {
        $branch = [];

        if (empty($nodes)) {
            $nodes = $this->allNodes();
        }

        foreach ($nodes as $node) {
            if ($node[$this->parentColumn] == $parentId) {
                $children = $this->buildNewNestedArray($nodes, $node[$this->getKeyName()],$defaultSelect);

                if ($children) {
                    foreach ($children as &$c){
                        if(in_array($c['category_id'],$defaultSelect)) {
                            $c['state'] = [
                                'checked' => true,
                            ];
                        }
                    }
                    $node['nodes'] = $children;
                }
                if(in_array($node['category_id'],$defaultSelect)) {
                    $node['state'] = [
                        'checked' => true,
                    ];
                }
                $branch[] = $node;
            }
        }

        return $branch;
    }

}
