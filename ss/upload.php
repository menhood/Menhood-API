<?php
session_start();
if (!isset($_SESSION['authorId'])) {
    header('location:index.php');
    exit('未登录！将跳转首页登录');
}

header('Content-type: application/json');
$a = explode(".",$_FILES["file"]["name"]);
$root_url = str_replace("upload.php","",$_SERVER["REQUEST_SCHEME"]."://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]);
if($_POST["action"] =="del"){
    $file = "imgs/".$_POST["cid"]."_".$_POST["index"].".".$a[1];
    if(unlink($file)){
        echo '{"code":0,"msg":"删除成功！"}';exit();
    }else{
        echo '{"code":1,"msg":"删除失败！"}';exit();
    }
}

$name = "post_img_".$_POST['cid'].'_'.$_POST['index'].".".end($a);
if ($_FILES["file"]["error"] > 0) {
    echo '{"code":1,"msg":"'.$_FILES["file"]["error"].'"';
} else
{
    if (file_exists("imgs/".$name)) {
        echo "{\"code\":1,\"msg\":\"图片已存在！\",\"url\":\"".$root_url."imgs/".$name."\"}";
    } else
    {
        move_uploaded_file($_FILES["file"]["tmp_name"],"imgs/".$name);
        echo "{\"code\":0,\"msg\":\"上传成功！\",\"url\":\"".$root_url."imgs/".$name."\"}";
    }
}