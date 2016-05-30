<?php
//设置时区
date_default_timezone_set('Asia/shanghai');
ob_start();
include dirname(__FILE__) . '/include/function.php';
include __DIR__.'/config.php';

//连接数据库
$db = @new Mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);//new 一个人对象
$db->set_charset('utf8');
if ($db->connect_errno) {
    die($db->connect_error);
}

?>