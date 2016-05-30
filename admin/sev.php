<?php
var_dump ($_POST);
include 'remember_log_in.php';

echo 2;
if (is_post()) {
    $title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
    $content = isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '';
    $excerpt = isset($_POST['excerpt']) ? htmlspecialchars($_POST['excerpt']) : '';
    $postdate = isset($_POST['postdate']) ? strtotime($_POST['postdate']) : '';
    $postdate = $postdate ? $postdate : time();
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $db = new ArticleModel();
    if ($id) {
        $values_arr = array($title, $content, $excerpt, $postdate, $id);
        if ($db->updateartlist($values_arr)) {
            go_to('admin_log.php?operation=3');
            exit();
        }
        go_to('admin_log.php?operation=-3');
        exit();
    } else {
        $values_arr = array($title, $content, $excerpt, $postdate);
        if ($db->writartlist($values_arr)) {
            go_to('admin_log.php?operation=1');
            exit();
        }
        go_to('admin_log.php?operation=-1');
        exit();
    }


//    var_dump ($title, $content, $id);
//    $stmt = $db->stmt_init ();
//    if (isset($_GET['id'])) {
//        $sql = 'UPDATE `news` SET `title`=?, `content`=?,`excerpt`=?,`postdate`=? WHERE `id`=?';
//    } else {
//        $sql = 'INSERT INTO `news`( `title`, `content`,`excerpt`,`postdate`) 
//           VALUES (?,?,?,?)';
//    }
//
//    if (!$stmt->prepare ($sql)) {
//        die($stmt->error);
//    }
//    if (isset($_GET['id'])) {
//        if (!$stmt->bind_param ('sssii', $title, $content, $excerpt, $postdate, $id)) {
//            die($stmt->error);
//        }
//    } else {
//        if (!$stmt->bind_param ('sssi', $title, $content, $excerpt, $postdate)) {
//            die($stmt->error);
//        }
//    }
//
//    if (!$stmt->execute ()) {
//        die($stmt->error);
//    }
//    if (isset($_GET['id'])) {
//        if ($db->affected_rows > 0) {
//            header ('location:admin_log.php');
//        } else {
//            echo '修改失败';
//        }
//    } else {
//        if ($db->affected_rows > 0) {
//            echo '发布成功';
//        } else {
//            echo '发布失败';
//        }
//    }
//    if (!empty($rows)) {
//
//    } else {
//
//    }
}
