<?php
//数据库连接信息
$db_host = 'localhost';
$db_name = 'ss';
$db_user = 'ss';
$db_password = '123456';
$db_port = '3306';

//用户信息
$config = Array('a'=>'123456','b'=>'123456');//账号密码

$conn = mysqli_connect($db_host,$db_user,$db_password,$db_name,$db_port);
mysqli_query($conn,"set names utf8mb4");

if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}