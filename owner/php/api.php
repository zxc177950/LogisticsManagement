<?php
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
if ($type == 'getUserInfor') {
    echo $main->getUserInfor();
}
if ($type == 'saveUserInfor') {
    echo $main->saveUserInfor();
}
if ($type == 'updatePass') {
    echo $main->updatePass();
}
if ($type == 'outOrder') {
    echo $main->outOrder();
}
if ($type == 'gainFate') {
    echo $main->gainFate();
}