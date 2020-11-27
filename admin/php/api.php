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
if ($type == 'getCarType') {
    echo $main->getCarType();
}
if ($type == 'delCar') {
    echo $main->delCar();
}
if ($type == 'addCar') {
    echo $main->addCar();
}
if ($type == 'getGoodType') {
    echo $main->getGoodType();
}
if ($type == 'delGood') {
    echo $main->delGood();
}
if ($type == 'addGood') {
    echo $main->addGood();
}
if ($type == 'getPrice') {
    echo $main->getPrice();
}
if ($type == 'savePrice') {
    echo $main->savePrice();
}
if ($type == 'getTax') {
    echo $main->getTax();
}
if ($type == 'saveTax') {
    echo $main->saveTax();
}
if ($type == 'getUser') {
    echo $main->getUser();
}
if ($type == 'freezeUser') {
    echo $main->freezeUser();
}
if ($type == 'unfreezeUser') {
    echo $main->unfreezeUser();
}