<?php
include dirname(__DIR__) . '/init.php';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$log = new Log_in();
if (!$log->remember_log()){
    $warning = $log->user_log();
    include 'views/log_in.html';
    exit();
    }
if (isset($_REQUEST['logout'])){
    $log->log_out();
}



