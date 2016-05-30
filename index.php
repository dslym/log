<?php
include 'init.php';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$content = new ArticleModel();
$db = new CommentModel();

switch ($action) {
    case 'red':
        $content = $content->showone($_GET['rid']);
//        var_dump($content);

        $cm_rows = $db->comment($_GET['rid']);
//        var_dump($cm_rows);
        include 'content/views/read.html';
        break;
    case 'comment':
//        var_dump($_POST);
        $atcid=isset($_GET['atcid'])?intval($_GET['atcid']):0;
        $name=isset($_POST['com_u'])?htmlspecialchars($_POST['com_u']):'';
        $content=isset($_POST['c_content'])?htmlspecialchars($_POST['c_content']):'';
        $time=time();
        $arr=array($atcid,$name,$content,$time);
//        var_dump($arr);
        if($db->writecomment($arr)){
            go_to('index.php?action=red&rid='.$atcid.'');
        }
        break;
    default;
        $content = $content->redartlist(5, 5);
//var_dump($content);
        $rows = $content['rows'];
        $row = $content['row'];
        $show = $content['show'];
//        var_dump($show);
        include 'content/views/index.html';
        break;
}

