<?php

class Log_in
{
    private $db;

    public function __construct()
    {
        session_start();
        $this->db = new MyMysqli();
    }

    public function user_log()
    {
        if (isset($_SESSION['user_info'])) {
            header('location:write_log.php');
        }
        if (is_post()) {
            $user = isset($_POST['user']) ? $_POST['user'] : '';
            $pw = isset($_POST['pw']) ? $_POST['pw'] : '';
            $cod = isset($_POST['imgcode']) ? intval($_POST['imgcode']) : '';
            $pd = isset($_POST['ispersis']) ?: false;
            if (isset($_SESSION['yy'])) {
                $n = $_SESSION['yy'];
                switch ($n['1']) {
                    case '+':
                        $ok = $n[0] + $n[2];
                        break;
                    case '-';
                        $ok = $n[0] - $n[2];
                        break;
                }
                if ($ok === $cod) {
                    $arr = array($user, $pw);
//                    var_dump($arr);
                    $sql = 'SELECT * FROM `user` WHERE `u_id`=%s AND `u_ps`=%s';
                    if (!$this->db->bind_query($sql, $arr)) {
                        echo 1;
                        zmMsg($this->db->get_stmt_error());
                    }
                    echo 2;
                    if (($row = $this->db->fetch(true)) === false) {
                        echo 3;
                        zmMsg($this->db->get_stmt_error());
                    }

                    if (!empty($row)) {
//                        var_dump($row);
                        $info = serialize($row);
                        $_SESSION['user_info'] = $info;
                        var_dump($_REQUEST);
                         isset( $_REQUEST['rmb'])?$time=time()+3600*24*7:0;
                        setcookie('user_info', $row['u_id'] . '-' . md5($info),$time,'/','',false,true);
                        header('location:write_log.php');
                    } else {
                        return '账号或密码错误';
                    }
                } else {
                    return '验证码错误';
                }
            }
        }
    }

    //记住登录
    public function remember_log()
    {
        //检查手否存在cookie信息
//        echo 1;
        if (!empty($_COOKIE['user_info'])) {
            //分割cookie信息
//            echo 2;
            $info = explode('-', $_COOKIE['user_info']);
//            var_dump($info);
            if (count($info) != 2) {
                echo 3;
                return false;
            }
//            echo 4;
            if (!empty($_SESSION['user_info'])) {
//                echo 5;
                return md5($_SESSION['user_info']) === $info[1];
            } else {
//                echo 6;
                $sql = 'SELECT * FROM `user` WHERE `u_id`=%s ';
                if (!$this->db->bind_query($sql, array($info['0']))) {
                    echo 7;
                    zmMsg($this->db->get_stmt_error());
                }
                if (($row = $this->db->fetch(true)) === false) {
                    zmMsg($this->db->get_stmt_error());
                }
                if (empty($row)) {
                    return false;
                }
                $u = serialize($row);
                if (md5($u) === $info[1]) {
                    $_SESSION['user_info'] = $u;
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    //退出登录
    public function log_out()
    {
        setcookie('user_info', '',-1,'/','',false,true);
        session_destroy();
        go_to('index.php');
    }
}