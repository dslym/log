<?php
include 'remember_log_in.php';
$comment = new CommentModel();

switch ($action) {
    case 'return':
//        var_dump($_POST);
//        exit();
        $arr=array($_POST['nr'],intval($_GET['rid']));
        if($comment->returncomment($arr)){
//            var_dump($arr);
//            go_to('../index.php?read=admin&action=red&rid='.$arr[1].'');
        }
        break;
    default;
        $comment = $comment->redacomment(5, 5);
        $rows = $comment['rows'];
        $row = $comment['row'];
        $show = $comment['show'];
        include 'views/comment.html';
}










