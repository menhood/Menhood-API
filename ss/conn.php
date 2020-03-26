<?php
//数据库连接信息
$db_host = 'localhost';
$db_name = 'ss';
$db_user = 'ss';
$db_password = 'Hn8yTSA4mjNhmY6p';
$db_port = '3306';

//用户信息
$config = Array(
    'admin'=>array(
        'name'=>'援军',
        'authorId'=>'1',
        'password'=>'Ll123456789',
        "mail"=>"menhood@menhood.wang"),
    'demo'=>array(
        'name'=>'援军小号',
        'authorId'=>'2',
        'password'=>'demo123456789',
        "mail"=>"250662670@qq.com")
        );//账号密码

$conn = mysqli_connect($db_host,$db_user,$db_password,$db_name,$db_port);
mysqli_query($conn,"set names utf8mb4");

if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}