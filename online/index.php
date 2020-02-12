<?php
/*
@ PHP 在线人数统计程序
Copyright (c) by Pader 1:25 2009年1月7日
How to use it: <script src="online.php"></script>
note: 一般独立在线人数统计程序都是统计在线的IP数，而这并不准确
例如局域网的访问者，比如公司，学校机房和网吧，虽然内网IP不同，但是外网IP都是一样
如果同一个局域网的无论多少人人访问你的网站则只被认为是一个人
这个小巧的程序解决了此问题，它以电脑为单为，每台电脑便算一个访问者
当然因为使用的是COOKIE，如果你在同一台电脑上使用两种不同核心的浏览器访问那就别当别论了
modify by menhood
*/

$url = $_GET['url'];
$info = $_GET['info'];
$onlinetime = intval($_GET['time']);
if(!empty($url)){
	$filename =  'data/'.md5($url).'online.txt';  //数据文件，如果没有新建
}else{
	$filename =  'data/'.md5($_SERVER['HTTP_REFERER']).'online.txt';  //数据文件，如果没有新建
	}

if(!empty($onlinetime) || $onlinetime <60){
$onlinetime = 600;  //在线有效时间，单位：秒 (即600等于10分钟)
}
$cookiename = 'C_OnLineCount';  //cookie名称
 
@$online = file($filename); //数据文件，如果没有新建
$nowtime = time(); 
$nowonline = array();
 
/*
@ 得到仍然有效的数据
*/
if(!empty($online)){
foreach($online as $line) {
$row = explode('|',$line);
$sesstime = trim($row[1]);
if(($nowtime - $sesstime) <= $onlinetime) {  //如果仍在有效时间内，则数据继续保存，否则被放弃不再统计
$nowonline[$row[0]] = $sesstime;  //获取在线列表到数组，会话ID为键名，最后通信时间为键值
}
}
}
/*
@ 创建访问者通信状态
使用cookie通信
COOKIE 将在关闭浏览器时失效，但如果不关闭浏览器，此 COOKIE 将一直有效，直到程序设置的在线时间超时
*/
if(isset($_COOKIE[$cookiename])) {  //如果有COOKIE即并非初次访问则不添加人数并更新通信时间
$uid = $_COOKIE[$cookiename];
} else {  //如果没有COOKIE即是初次访问
$vid = 0;  //初始化访问者ID
do {  //给用户一个新ID
$vid++;
$uid = 'U'.$vid;
} while (array_key_exists($uid,$nowonline));
setcookie($cookiename,$uid);
}
$nowonline[$uid] = $nowtime;  //更新现在的时间状态
 
/*
@ 统计现在在线人数
*/
$total_online = count($nowonline);
 
/*
@ 写入数据
*/
if($fp = @fopen($filename,'w')) {
if(flock($fp,LOCK_EX)) {
rewind($fp);
foreach($nowonline as $fuid => $ftime) {
$fline = $fuid.'|'.$ftime."\n";
@fputs($fp,$fline); 
}
flock($fp,LOCK_UN);
fclose($fp);
}
}
echo 'var c_online = '.$total_online.';';
if($info == 'on'){echo 'var s_url = "'.$onlinetime.'";';}
?>