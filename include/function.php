<?php

/**
 * 截取编码为utf8的字符串
 *
 * @param string $strings 预处理字符串
 * @param int $start 开始处 eg:0
 * @param int $length 截取长度
 */
function subString($strings, $start, $length)
{
    if (function_exists('mb_substr') && function_exists('mb_strlen')) {
        $sub_str = mb_substr($strings, $start, $length, 'utf8');
        return mb_strlen($sub_str, 'utf8') < mb_strlen($strings, 'utf8') ? $sub_str . '······' : $sub_str;
    }
    $str = substr($strings, $start, $length);
    $char = 0;
    for ($i = 0; $i < strlen($str); $i++) {
        if (ord($str[$i]) >= 128) {
            $char++;
        }

    }
    $str2 = substr($strings, $start, $length + 1);
    $str3 = substr($strings, $start, $length + 2);
    if ($char % 3 == 1) {
        if ($length <= strlen($strings)) {
            $str3 = $str3 .= '······';
        }
        return $str3;
    }
    if ($char % 3 == 2) {
        if ($length <= strlen($strings)) {
            $str2 = $str2 .= '······';
        }
        return $str2;
    }
    if ($char % 3 == 0) {
        if ($length <= strlen($strings)) {
            $str = $str .= '······';
        }
        return $str;
    }
}

/**
 * 从可能包含html标记的内容中萃取纯文本摘要
 *
 * @param string $data
 * @param int $len
 */
function extractHtmlData($data, $len, $status = false)
{
    $data = $status ? htmlspecialchars_decode($data) : $data;
    $data = subString(strip_tags($data), 0, $len + 30);
    $search = array("/([\r\n])[\s]+/", // 去掉空白字符
        "/&(quot|#34);/i", // 替换 HTML 实体
        "/&(amp|#38);/i",
        "/&(lt|#60);/i",
        "/&(gt|#62);/i",
        "/&(nbsp|#160);/i",
        "/&(iexcl|#161);/i",
        "/&(cent|#162);/i",
        "/&(pound|#163);/i",
        "/&(copy|#169);/i",
        "/\"/i",
    );
    $replace = array(" ", "\"", "&", " ", " ", "", chr(161), chr(162), chr(163), chr(169), "");
    $data = trim(subString(preg_replace($search, $replace, $data), 0, $len));
    return $data;
}


//跳转
function go_to($url){

    header('location:'.$url);
}

//自动加载类
/**
 * @param $class 类名
 */
function autoload($class)
{
    if (file_exists(__DIR__ . '/lib/' . $class . '.class.php')) {
        require __DIR__ . '/lib/' . $class . '.class.php';
    } elseif (file_exists(__DIR__ . '/Model/' . $class . '.class.php')) {
        require __DIR__ . '/Model/' . $class . '.class.php';
    } else {
        zmMsg($class . '类加载失败');
    }
}

spl_autoload_register('autoload');
//var_dump(dirname(__FILE__)).'/lib/'.;
// 连接数据库函数
// var_dump($_POST);
// $h='127.0.0.1';
// $u='root';
// $p='';
// $db='log_in';
// sql_connect($h, $u, $p, $db);
//function sql_connect($h, $u, $p, $db) {
//	$link = mysqli_connect ( $h, $u, $p, $db );
//	mysqli_set_charset ( $link, 'utf8' );
//	// var_dump($link);
//	return $link;
//}
// 查询一条数据
// $field='id';
// $table='log_in_table';
// $where="user_id='{$_POST['user_id']}' && user_pass='{$post_md5}'";
// var_dump ( $sql )
/**
 * @param $link
 * @param $field
 * @param $table
 * @param $where
 * @return array|bool
 */
function sql_select_one($link, $field, $table, $where)
{
    $sql = "SELECT $field FROM $table WHERE $where";
    var_dump($sql);
    $res = mysqli_query($link, $sql);
    $sql_arr = [];
    while ($res1 = mysqli_fetch_assoc($res)) {
        $sql_arr [] = $res1;
        if (count($sql_arr) == 1 && $sql_arr != null) {
            return $sql_arr;
        } else {
            return false;
        }
    }
}

// 去空格
/** 去掉空格
 * @param $str  需要处理的字符串
 * @return bool|string  返回处理后的结果
 */
function trim_str($str)
{
    $str = trim($str);
    $str = addslashes($str);
    if (!empty ($str)) {
        return $str;
    }
    return false;
}

// 字符串长度判断
function str_len($str, $min, $max)
{
    $str_len = mb_strlen($str);
    if ($str_len >= $min && $str_len <= $max) {
        return $str;
    } else {
        return false;
    }
}

// 数据库插入数据
function insertinto($link, $table, $field, $values)
{
    $sql = "INSERT INTO $table($field) VALUES ($values)";
    //echo ($sql);
    $sql1 = mysqli_query($link, $sql); // var_dump($sql);
    // var_dump($sql1);
    if ($sql1) {
        // var_dump($sql1);
        return true;
    }
    return false;
}

// 查所有询数据取出几条
function sql_select_all($link, $field, $table, $where, $page, $num)
{
    $sql = "SELECT $field FROM $table WHERE $where ORDER BY `u_time` DESC LIMIT $page,$num";
    //var_dump ( $sql );
    $res = mysqli_query($link, $sql);
    $sql_arr = [];
    while ($res1 = mysqli_fetch_assoc($res)) {
        $sql_arr [] = $res1;
    }
    if (!empty ($sql_arr)) {
        return $sql_arr;
    }
    return false;
}

//删除数据
function sql_delete($link, $table, $where = 0)
{
    $sql = "DELETE FROM $table WHERE $where";
    $res = mysqli_query($link, $sql);
    if ($res) {
        return true;
    }
    return false;
}

//修改数据
function sql_update($link, $table, $value, $where)
{
    $sql = "UPDATE $table SET $value WHERE $where";
    var_dump($sql);
    $res = mysqli_query($link, $sql);
    if ($res) {
        return true;
    }
    return false;
}


//多表查询
function sql_join_one($link, $id)
{
    $sql = "SELECT * FROM user_info WHERE `user_id`=$id";
    //var_dump($sql);
    $res = mysqli_query($link, $sql);
    $sql_arr = [];
    while ($res1 = mysqli_fetch_assoc($res)) {
        $sql_arr [] = $res1;
    }
    if (!empty ($sql_arr)) {
        return $sql_arr;
    }
    return false;
}

//插入一条
function insert_one($link, $table, $field, $values, $where)
{
    $sql = "INSERT INTO $table($field) VALUES ($values) WHERE user_id=$where";
    echo($sql);
    $sql1 = mysqli_query($link, $sql); // var_dump($sql);
    // var_dump($sql1);
    if ($sql1) {
        // var_dump($sql1);
        return true;
    }
    return false;
}

//查询所有
function select_all($link, $field, $table, $where)
{
    $sql = "SELECT $field FROM $table WHERE $where ";
    var_dump($sql);
    $res = mysqli_query($link, $sql);
    $sql_arr = [];
    while ($res1 = mysqli_fetch_assoc($res)) {
        $sql_arr [] = $res1;
    }
    if (!empty ($sql_arr)) {
        return $sql_arr;
    }
    return false;
}

//判断接是否 post 接收
/**
 * @return bool
 */
function is_post()
{
    return (isset($_SERVER['REQUEST_METHOD']) && ('POST' == $_SERVER['REQUEST_METHOD']));
}

//自定义错误提示页面
/**
 * [zmMsg 显示消息的function]
 * @Author   ZiShang520
 * @DateTime 2016-02-24T17:05:59+0800
 * @param    [type]                   $msg      [description]
 * @param    string $url [description]
 * @param    boolean $isAutoGo [description]
 * @return   [type]                             [description]
 */
function zmMsg($msg, $url = 'javascript:history.back(-1);', $isAutoGo = false)
{
    if ('404' == $msg) {
        header("HTTP/1.1 404 Not Found");
        $msg = '抱歉，你所请求的页面不存在！';
    }
    echo <<<EOT
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

EOT;
    if ($isAutoGo) {
        echo "<meta http-equiv=\"refresh\" content=\"2;url=$url\" />";
    }
    echo <<<EOT
    <title>提示信息</title>
    <style type="text/css">
        body { background-color:#F7F7F7; font-family: Arial; font-size: 12px; line-height:150%; } .main { background-color:#FFFFFF; font-size: 12px; color: #666666; width:650px; margin:60px auto 0px; border-radius: 10px; padding:30px 10px; list-style:none; border:#DFDFDF 1px solid; } .main p { line-height: 18px; margin: 5px 20px; }
    </style>
</head>

<body>
    <div class="main">
        <p>$msg</p>

EOT;
    if ('none' != $url) {
        echo '        <p><a href="' . $url . '">&laquo;点击返回</a></p>';
    }
    echo <<<EOT

    </div>
</body>

</html>
EOT;
    exit;
}
