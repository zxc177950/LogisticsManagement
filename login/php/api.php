<?php
/**
 * Created by PhpStorm.
 * User: 13673
 * Date: 2019-09-27
 * Time: 20:09
 */
header('Content-Type: application/json');
header('Content-type:text/html;charset=utf-8');
//指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
//响应类型
//header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Methods:*');
//响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');

require_once('main.php');

$type = @$_GET['type'];
$main = new Main();
if ($type == 'login') {
    echo $main->login();
}
if ($type == 'register') {
    echo $main->register();
}