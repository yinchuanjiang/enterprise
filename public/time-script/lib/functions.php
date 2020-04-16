<?php
/**
 * 记录日志
 */
function addLog($file, $content){
    $dir = dirname(dirname(__FILE__)).'/logs/'.date('Ym').'/'.date('d').'/';
    is_dir($dir) or mkdir($dir, 0777, true);

    $content = '时间：'.date('Y-m-d H:i:s').PHP_EOL.'信息：'.$content.PHP_EOL.'----------------------------------------'.PHP_EOL;
    file_put_contents($dir.$file, $content, FILE_APPEND);
}

/**
 * 打印数据
 */
function dd1($data){
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
}

/**
 * curlPost
 */
function curlPost($url, $data, $header){    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        addLog('error.log', json_encode(curl_error($ch)));
    }

    return $response;
}

/**
 * getAccessToken
 */
function getAccessToken(){
	return @file_get_contents('https://ieguoyuan.iyker.com/weixin/index/getAccessToken');
}
