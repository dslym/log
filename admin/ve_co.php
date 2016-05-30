<?php
//验证码
header ('content-type:image/jpeg');
$img = imagecreatefromjpeg ('views/imag/002.jpg');  //获取图片资源
$bg = imagecreatetruecolor (400, 100);      ////创建背景
imagecopyresampled ($bg, $img, 0, 0, 0, 0, 400, 100, 200, 50);   //比例缩放
$arr_f = ['+', '-'];
for ($i = 0, $arr = []; $i <= 3; $i++) {
    $num = 'num' . $i;
    $tx_c = imagecolorallocate ($bg, mt_rand (100, 255), mt_rand (0, 50), mt_rand (100, 255));
    if ($i == 0 || $i == 2) {
        imagettftext ($bg, 30, 5, 30 + $i * 88, 50, $tx_c, 'views/font/123.ttf', $$num = mt_rand (1, 10));
    } elseif ($i == 1) {
        imagettftext ($bg, 35, 0, 150, 60, $tx_c, 'views/font/123.ttf', $$num = $arr_f[mt_rand (0, 1)]);
    } elseif ($i == 3) {
        imagettftext ($bg, 30, -5, 320, 50, $tx_c, 'views/font/123.ttf', $$num = ' = ?');
    }
    $arr[] = $$num;
}
session_start ();
$_SESSION['yy'] = $arr;
for ($i = 0; $i <= 5; $i++) {
    $line_c = imagecolorallocate ($bg, mt_rand (0, 255), mt_rand (0, 255), mt_rand (0, 255));
    imageline ($bg, mt_rand (0, 400), mt_rand (0, 100), mt_rand (0, 400), mt_rand (0, 100), $line_c);
}
imagejpeg ($bg);