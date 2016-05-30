<?php
////function text($a)
////{
////    if ($a % 2 == 0) {
////        $num = $a / 2;
////        for ($i = $num; $i > 1; $i--) {
////            $a = floor($a / 2);
////            echo $a . '<br>';
////
////        }
////
////    } else {
////        $num = ($a - 1) / 2;
////        $a -= 1;
////        for ($i = $num; $i > 2; $i--) {
////            $a = floor($a / 2) ;
////            echo $a . '<br>';
////            if ($a==1){
////                break;
////            }
////        }
////    }
////}
////text(9);
//
//$a=80;
// text($a);
//function  text($a){
//    if ($a % 2 == 0) {
//        $a = ($a / 2);
//        echo $a . '<br>';
//    }else{
//        $a = ($a-1) / 2;
//        echo $a . '<br>';
//    }
//    if ($a>1){
//        text($a);
//    }
//}
//


//$sql="UPDATE `logo` SET `title`='{$_POST['title']}'";


//function mmp($max){
//    for ($i = 1, $arr = []; ; $i++) {
//        $m = 1 * pow (3, $i - 1);
//        $arr[] = $m;
//        if (count ($arr) == $max) {
//            return $arr;
//        }
//    }
//}
//var_dump (mmp (10));

//$a=[1,2,3,80,5,9];
//function cnm($arr)
//{
//    arsort ($arr);
//    $max = each  ($arr);
//   return $max[0];
//
//}
//var_dump(cnm($a));
//function rnm($max)
//{
//    for ($i = 1, $arr = [0], $a = 1, $b = 0; ; $i++) {
//        $c = $a + $b;
//        $a = $b;
//        $b = $c;
//        $arr[] = $c;
//        if (count($arr) == $max) {
//            return $arr;
//        }
//    }
//}
//    protected function f1(){
//
//    }
//    private function  f2(){
//
//    }
//    public function ec_ho(){
//        echo self::P;
//    }
//    const P=7;
//}
//$a=new test();
//$a->ec_ho();

////echo date('Y-m-d H:i:s',strtotime('-1 day'));
//function deletedir($dir){
//    if (is_dir($dir)) {
//        $look=opendir($dir);
//        while ($file=readdir($look)) {
//            if ($file!='.'&&$file!='. .') {
//                $path=$dir.'/'.$file;
//                if (is_file($path)) {
//                    unlink($pash);
//                }else{
//                    deletedir($path);
//                }
//            }
//        }
//        rmdir($dir);
//        fclose($look);
//    }else{
//        return 'no';
//    }
//}
//deletedir();

//
//?>
<?php
//function is_post(){
//    return (isset($_SERVER['REQUEST_METHOD'])&&('POST'==$_SERVER['REQUEST_METHOD']));
//}
//if (is_post ()){
//    var_dump ($_POST);
//    $msg=$_POST['message'];
//    $time=strtotime ($_POST['time']);
//    var_dump ($msg,$time);
////    $db=new mysqli('127.0.0.1','root','','mydb');
////    $sql = "INSERT INTO `news`( `msg`, `time`)
////            VALUES ('{$msg}',$time)";
////    $re=$db->query ($sql);
////    if ($re){
////        var_dump '留言成功';
////    }else{
////        a '留言失败';
////    }
//    $a=2;
//    var_dump $a <<= 2;
//}

//var_dump ('Hello world');
//
//$a = 20;
//
//$b = 40;
//
//$c = $a + $b;
//
// $c.='<br>';
//
//var_dump('Hello world') ;
//
//$stmt=$db->stmt_init ();
//$sql
//$stmt->prepare ($stmt, )
//?>
