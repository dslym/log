<?php
include dirname (__DIR__) . '/init.php';
if (is_post ()) {
    var_dump ($_POST);
    $u = isset($_POST['u']) ? addslashes ($_POST['u']) : '';
    $p = isset($_POST['p']) ? addslashes ($_POST['p']) : '';
    if ($u != '' && $p != '') {
//        $db = @new Mysqli('127.0.0.1', 'root', '', 'test', 3306);    //new 一个人对象
//    var_dump ($db->connect_error);
//        if ($db->connect_errno) {
//            die($db->connect_error);
//        }
//         $sql = 'SELECT * FROM `user` WHERE `u_id`="' . $u . '"AND `u_ps`="' . $p . '"';    //sql语句生成
// //    var_dump ($sql);
//         if (!$result = $db->query ($sql) /*查询SQL语句 赋给某个变量*/) {
//             die($db->error);
//         }
//         if (!$rows = $result->fetch_assoc ()/*取出 查询结果*/) {
//             echo '账号或密码错误';
//         } else { 
//             header ('location:write_log.php');
//             exit();
//         }
        //初始化stmt子类
        $stmt = $db->stmt_init ();
        var_dump ($stmt);
        //创建sql模板， ?半角问号是占位符 注意如果绑定值是字符串也不用加引号
        $sql = 'SELECT * FROM `user` WHERE `u_id`=? AND `u_ps`=?';
        var_dump ($sql);
        //预处理sql语句 用于判断sql语句中的表 字段 是否存在 
        if (!$stmt->prepare ($sql)) {
            #如果如处理失败输出错误结果
            echo '111';
            die($stmt->error);
        }
        //绑定参数
        if (!$stmt->bind_param ('ss', $u, $p)) {
            die($stmt->error);
        }//第一个参数为字符串 根据sql模板中？个数从左到右依次填入第二个参数为 ？镀银的变量 注意此处变量为引用传值
        //？一一对应

        //执行sql 语句
        if (!$stmt->execute ()) {
            die($stmt->error);
        }
//		     var_dump('wosjo');
        header ('location:write_log.php');
    } else {
        echo '账号或密码不能空';
    }
}
include 'views/login.html';