<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header('location:index.php');
    exit('未登录！将跳转首页登录');
}

// $dest_floder = 'imgs/';
// //图片保存路径
// $tmp_name = $_FILES['uploads']['tmp_name'];
// $a = explode(".",$_FILES['uploads']['name']);
// //截取文件名和后缀
// $name = date('Ymdhis').mt_rand(100,999).".".$a[1];
// //文件重命名
// $uploadfile = $dest_floder.$name;
// move_uploaded_file($tmp_name,$uploadfile);

header('Content-type: application/json');
// echo '{"code":0,"msg":"上传成功"}';
$a = explode(".",$_FILES['file']['name']);
$name = date('Ymdhis').md5($_FILES["file"]["name"]).".".$a[1];
// var_dump($_FILES[]);
if ($_FILES["file"]["error"] > 0) {
    echo '{"code":1,"msg":"'.$_FILES["file"]["error"].'"';
} else
{
    if (file_exists("imgs/" . $name)) {
        echo '{"code":1,"msg":"图片已存在！","img":"imgs/'.$name.'"}';
    } else
    {
        move_uploaded_file($_FILES["file"]["tmp_name"],"imgs/" . $name);
        echo '{"code":0,"msg":"上传成功！","img":"imgs/'.$name.'"}';
    }
}