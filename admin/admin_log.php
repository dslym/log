<?php
//var_dump (1);
include 'remember_log_in.php';
//法1
//include dirname (__DIR__) . '/include/lib/Page.class.php';
//$db=new myMysqli();
//if (!$db->bind_query('SELECT count(id) AS num FROM `news` WHERE 1')){
//    zmMsg($db->get_stmt_error());
//}
//if (!$row=$db->fetch(true)){
//    zmMsg($db->get_stmt_error());
//}
//$show=new Page($row['num'],2,6);
//if (!$db->bind_query('SELECT * FROM `news` GROUP BY `id` DESC LIMIT %d,%d',array($show->first_rows,$show->page_num_rows))){
//    zmMsg($db->get_stmt_error());
//}
//if (!$rows=$db->fetch()){
//    zmMsg($db->get_stmt_error());
//}
//$db->free_result();
//$db->stmt_close();
//$db->mysql_close();


//法2
//$row=$db->query ('SELECT count(id) FROM `news` WHERE 1')->fetch_row ();
//$sql = "SELECT * FROM `news` GROUP BY `id` DESC LIMIT ?,?";
//$re=$db->query($sql);
//$arr=[];
//while ($one=$re->fetch_assoc()){
//    $arr[]=$one;
//}
//var_dump($arr);

//初始化子类方法
//$stmt = $db->stmt_init ();
//if (!$stmt->prepare ($sql)) {
//    die($stmt->error);
//}
//$stmt->bind_param ('ii',$show->first_rows,$show->page_num_rows);
//$stmt->execute ();
//$stmt->store_result ();
////var_dump ($stmt->num_rows);
//if (!$stmt->num_rows > 0) {
//    die($stmt->error);
//}
//$stmt->bind_result ($id, $title, $content, $excerpt, $postdate);
//$arr = [];
//while ($stmt->fetch ()) {
//    $arr[] = array($id, $title, $content, $excerpt, $postdate);
//}

//法3
$db = new ArticleModel();
if ($action == 'delete') {
    $operate = isset($_POST['operate']) ? $_POST['operate'] : '';

    switch ($operate) {
        case 'del':
            var_dump($_POST);
            $did = isset($_POST['blog']) ? array_map('intval', $_POST['blog']) : array();
            $a = $db->del_artlist($did);
            if ($a > 0) {
                go_to('admin_log.php?operation=2');
                exit();
            }
            go_to('admin_log.php?operation=-2');
            exit();
            break;
    }

}
$artlist = new ArticleModel();
$artlist = $artlist->redartlist(5, 5);
$rows = $artlist['rows'];
$row = $artlist['row'];
$show = $artlist['show'];

include 'views/admin_log.html';


