<?php
//数据库连接信息
$db_host = 'localhost';
$db_name = 'ss';
$db_user = 'ss';
$db_password = '123456';
$db_port = '3306';

//用户信息
$config = Array(
    'admin'=>array(
        'name'=>'援军',
        'authorId'=>'1',
        'password'=>'mm123456789',
        "mail"=>"menhood@menhood.wang"，
        "bg_url"=>"bg.mp4"),
    'demo'=>array(
        'name'=>'援军小号',
        'authorId'=>'2',
        'password'=>'demo123456789',
        "mail"=>"menhood@menhood.wang")
        );//账号密码
//设置
$settings = Array(
    "upload_api"=>"https://img.menhood.wang/file.php"
    );//第三方图床api，为空则上传到imgs文件夹,根据需要修改edit.php upload() Ajax相关参数
$conn = mysqli_connect($db_host,$db_user,$db_password,$db_name,$db_port);
mysqli_query($conn,"set names utf8mb4");

if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}