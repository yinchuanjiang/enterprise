<?php
require 'Medoo.php';

use Medoo\Medoo;

/**
 * DbModel
 */
class DbModel {
	private $_db = null;

    public function __construct() {
    	// 初始化数据库
	    $this->_db = new Medoo(array(
	        'database_type' => 'mysql',
	        'server'        => 'localhost',
	        'username'      => 'luyangies',
	        'password'      => 'Prip2EPj6cXLZWPm',
	        'database_name' => 'luyangies',
	        'prefix'        => '',
	        'port'          => '3306',
	        'charset'       => 'utf8'
	    ));
    }   
    
    /**
     * 添加政策数据
     */
    public function addPolicy($data, $module_type, $government_id){
        if (empty($data)) {
            return false;
        }

        // 查询之前是否采集
        if($this->_db->has('t_store_policy',[
            'policy_title' => $data['policy_title'],
            'module_type'  => $module_type
        ])){
            return false;
        }
        
        $this->_db->pdo->beginTransaction(); // 开启事务

        try {
            // 添加政策数据
            $this->_db->insert('t_store_policy', $data);
            if ($this->_db->error()[0] != '00000') {
                throw new Exception('添加政策数据错误：'.$this->_db->error()[2]);
            }
            $policy_id = $this->_db->id();

            // 添加政策发文单位关联数据
            $this->_db->insert('t_store_policy_government',[
                'policy_id' => $policy_id,
                'government_id' => $government_id
            ]);
            if ($this->_db->error()[0] != '00000') {
                throw new Exception('添加政策发文单位关联数据错误：'.$this->_db->error()[2]);
            }

            // 添加政策关键词数据和政策行业数据
            /*$keywordLists = $this->_db->select('t_base_keywords','*');
            if ($keywordLists) {
                $policyKeywordData = [];

                foreach ($keywordLists as $key => $value) {
                    if (strpos($data['policy_content'], $value['keywords_name']) !== false) {
                        $policyKeywordData[] = array(
                            'policy_id'   => $policy_id,
                            'keywords_id' => $value['keywords_id']
                        );
                    }
                }

                if($policyKeywordData){
                    // 添加政策关键词数据
                    $this->_db->insert('t_store_policy_keywords', $policyKeywordData);
                    if ($this->_db->error()[0] != '00000') {
                        throw new Exception('添加政策关键词数据错误：'.$this->_db->error()[2]);
                    }
                }
            }*/
                    
            // 提交事务
            $this->_db->pdo->commit();

            // 记录成功日志
            addLog('spider-success.log', '数据插入成功，id：'.$policy_id);

        } catch (Exception $e) {
            addLog('spider-error.log', $e->getMessage());
            // 回滚事务
            $this->_db->pdo->rollBack();

        }

        return true;
    }
}
