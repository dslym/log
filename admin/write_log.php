<?php
include 'remember_log_in.php';
switch ($action) {
    case'edit':
        $id = isset($_GET['gid']) ? intval ($_GET['gid']) : 0;
        $db=new ArticleModel();
        $row=$db->showone($id);
        include 'views/write_log_action.html';
        break;
    default:
            include 'views/write_log.html';
        break;
}
