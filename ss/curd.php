<?php
session_start();
if (!isset($_SESSION['userid'])){header('location:index.php');exit('未登录！将跳转首页登录');}
date_default_timezone_set("PRC");
include('conn.php');
$sql_cmd_c = "CREATE TABLE IF NOT EXISTS `typecho_ss` (

  `cid` int(10) NOT NULL AUTO_INCREMENT,

  `title` varchar(255)  ,

  `slug` varchar(255)  ,

  `created` int(10)  ,

  `modified` int(10)  ,
  `text` longtext  ,
  `img` longtext  ,
  `order` int(10)  ,
  `authorId` int(10)  ,
  `template` varchar(32)  ,
  `type` varchar(16)  ,
  `status` varchar(16)  ,
  `password` varchar(32)  ,
  `commentsNum` int(10)  ,
  `allowComment` char(1)  ,
  `allowPing` char(1)  ,
  `allowFeed` char(1)  ,
  `parent` int(10)  ,
  PRIMARY KEY (`cid`)

) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4;";
$sql_cmd_i = "INSERT INTO typecho_ss (title,text,created) VALUES ('标题测试🤣','正文测试',".strtotime(date("H:i:s",time())).")";
$sql_cmd_u = "UPDATE typecho_ss SET title='标题更新测试',text='正文更新测试',modified=".strtotime(date("H:i:s",time()))."
WHERE cid=102 AND title='标题测试'";
$sql_cmd_r = "SELECT * FROM typecho_ss WHERE cid=2";
$sql_cmd_d = "DELETE FROM typecho_ss WHERE cid=11";
$sql_cmd_o = "SELECT * FROM typecho_ss ORDER BY cid";//根据cid排序
 
//判断表是否存在
if(isset($_GET['install'])){
    if(mysqli_query($conn,$sql_cmd_c)){echo "创建表成功<br>";};
    if(mysqli_query($conn,"INSERT INTO typecho_ss (cid,title,created,status) VALUES (2,'数据表建立',".strtotime(date("H:i:s",time())).",'1')")){echo "初始化成功<br>";}else{echo "插入初始化记录失败<br>";};
    echo "数据初始化完成<br><a href='index.php'>点此返回首页</a>";
}

//接受json格式数据并转码
$command =  isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
$POST = json_decode($command,TRUE);

//新增记录
if($POST['action'] == 'new'){
    $sql_cmd_new = "INSERT INTO typecho_ss (title,text,img,authorId,created,modified,status) VALUES ('".$POST['title']."','".$POST['text']."','".$POST['img']."','".$POST['authorId']."',".strtotime(date("H:i:s",time())).",".strtotime(date("H:i:s",time())).",status='".$POST['status']."')";
    $req = mysqli_query($conn,$sql_cmd_new);
    
    if(!$req){
        echo '{"code":1,"msg":"发布失败！"}';
        mysqli_close($conn);
        exit();
    }
    echo '{"code":0,"msg":"发布成功"}';
    mysqli_close($conn);
}
//修改记录
if($POST['action'] == 'edit'){
    $cid = $POST['cid'];
    $sql_cmd_edit = "UPDATE typecho_ss SET title='".$POST['title']."',text='".$POST['text']."',img='".json_encode($POST['img'])."',authorId='".$POST['authorId']."',modified='".strtotime(date("H:i:s",time()))."',status='".$POST['status']."' WHERE cid=".$cid.";";
    $req = mysqli_query($conn,$sql_cmd_edit);
    if(!$req){
        echo '{"code":1,"msg":"保存失败！cid：'.$cid.$datas[0].'"}';
        mysqli_close($conn);
        exit();
    }
    echo '{"code":0,"msg":"保存成功"}';
    mysqli_close($conn);
}
//隐藏记录
if($POST['action'] == 'del'){
    $cid = $POST['cid'];
    $sql_cmd_del = "UPDATE typecho_ss SET status='hidden' WHERE cid=".$cid;
    $req = mysqli_query($conn,$sql_cmd_del);
    if(!$req){
        echo '{"code":1,"msg":"操作失败！cid：'.$cid.'"}';
    }
    echo '{"code":0,"msg":"删除成功"}';
    mysqli_close($conn);
}
//恢复记录
// if($POST['action'] == 'resume'){
//     $cid = $POST['cid'];
//     $sql_cmd_resume = "UPDATE typecho_ss SET status=null WHERE cid=".$cid;
//     $req = mysqli_query($conn,$sql_cmd_resume);
//     if(!$req){
//         echo '{"code":1,"msg":"操作失败！cid：'.$cid.'"}';
//     }
//     echo '{"code":0,"msg":"删除成功"}';
//     mysqli_close($conn);
// }
//删除记录
if($POST['action'] == 'del_recycle'){
    $cid = $POST['cid'];
    if($cid==2){echo '{"code":1,"msg":"此条禁止删除！"}';exit();}
    $sql_cmd_del = "DELETE FROM typecho_ss WHERE cid=".$cid;
    $req = mysqli_query($conn,$sql_cmd_del);
    if(!$req){
        echo '{"code":1,"msg":"操作失败！cid：'.$cid.'"}';
    }
    echo '{"code":0,"msg":"彻底删除成功"}';
    mysqli_close($conn);
}