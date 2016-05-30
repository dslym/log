<?php
include dirname(dirname(__DIR__)) . '/init.php';

class MyredMysqli
{
    private $db;
    private static $stmt;

    /**
     * MyMysqli constructor.
     * @param $db_h  数据host
     * @param $db_u  数据库用户名
     * @param $db_ps 数据库密码
     * @param $db_n  使用的库名
     * @param $db_p  默认端口
     * @param $db_s  数据库编码方式
     */
    public function __construct
    (
        $db_h = DB_HOST,
        $db_u = DB_USER,
        $db_ps = DB_PASS,
        $db_n = DB_NAME,
        $db_p = DB_PORT,
        $db_s = 'utf8'
    )
    {
        //检查类是否存在
        class_exists('Mysqli', false) || zmMsg('PHP服务器不支持Mysqli数据');
        $this->db = @new Mysqli($db_h, $db_u, $db_ps, $db_n, $db_p);
        //判断并显示错误信息
        if ($this->db->connect_error) {
            zmMsg($this->db->connect_error);
        }
        //设置编码方式
        $this->db->set_charset($db_s);
        //检测方法是否存在
        method_exists($this->db, 'stmt_init') || zmMsg('Mysqli不支持stmt_init方法');
        self::$stmt = $this->db->stmt_init();
    }

    /**
     * @param $sql_s      sql语句；
     * @param $sql_price  sql需要绑定的值
     */
    public function bind_quary($sql_s, $sql_price=array())
    {
        $map = [
            '%s' => 's',#字符串
            '%d' => 'i',#整  型
            '%f' => 'd',#浮点型
            '%b' => 'b',#二进制
        ];
        $expr='/('.implode('|',array_keys($map) ).')/';
        //匹配数据
        if (preg_match_all($expr,$sql_s,$matches)){
            if (count($matches[0])!==count($sql_price)){
                zmMsg('传入sql绑定参数不符合');
            }
            $types=implode('',$matches[0] );
            $types=strtr($types, $map);
            //替换原始sql语句中的类型为？
            $query=preg_replace($expr, '?',$sql_s);
            //预处理sql
            if (self::$stmt->prepare($query)){
                array_unshift($sql_price,$types );
                $params=array();
                //sql引用问题解决
                foreach ($sql_price as $k=>$v){
                    $params [$k]=&$sql_price[$k];
                }
                //使用回调函数作为动态参数
                if (call_user_func_array(array(self::$stmt,'bind_param' ),$params)){
                    //执行sql语句
                    return self::$stmt->execute();
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            if (self::$stmt->prepare($sql_s)){
                return self::$stmt->execute();
            }else{
                return false;
            }
        }
    }
}

$test = @new MyMysqli();
var_dump($test->bind_quary('SELECT * FROM `news` GROUP BY `id` DESC LIMIT %d,%d',array(0,10) ));