<?php
ini_set("memory_limit", "10240M");
set_time_limit(0);
date_default_timezone_set('PRC');

/**
 * 每天把热搜前10关键词写入到t_hotsearch表
 */
$rootPath = dirname(dirname(__FILE__));
require $rootPath.'/time-script/lib/config.php';
require $rootPath.'/time-script/lib/Medoo.php';
require $rootPath.'/time-script/lib/functions.php';

use Medoo\Medoo;

// 初始化数据库
$database = new Medoo($mysql);

$sql   = "SELECT keywords,COUNT(*) heat,search_url FROM t_hotsearch_record GROUP BY keywords ORDER BY heat DESC LIMIT 10";
$lists = $database->query($sql)->fetchAll(PDO::FETCH_ASSOC);

if ($lists) {
	foreach ($lists as $key => $value) {
		$lists[$key]['create_time'] = date('Y-m-d H:i:s');
	}

	// 开启事务
	$database->pdo->beginTransaction();

	try {
		// 删除热搜关键词数据
	    $database->delete('t_hotsearch',[]);
	    if ($database->error()[0] != '00000') {
	    	throw new Exception('删除热搜关键词数据错误：'.$database->error()[2]);
	    }

		// 添加热搜关键词数据
	    $database->insert('t_hotsearch', $lists);
		if ($database->error()[0] != '00000') {
	    	throw new Exception('添加热搜关键词数据错误：'.$database->error()[2]);
	    }
	    	    
		// 提交事务
		$database->pdo->commit();
		addLog('hotsearch-success.log', '添加热搜关键词成功，关键词为：'.json_encode(array_column($lists, 'keywords'), JSON_UNESCAPED_UNICODE));

	} catch (Exception $e) {
		addLog('hotsearch-error.log', $e->getMessage());
		// 回滚事务
		$database->pdo->rollBack();

	}
}