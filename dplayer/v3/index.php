<?php
//v3版本后端，dplayer版本号1.25.0适用
header("Access-Control-Allow-Headers:x-requested-with,content-type");
header("Access-Control-Allow-Method: PUT, POST, GET, DELETE, OPTIONS");
header("Access-Control-Allow-Origin: *");
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit();
}
//读取（GET）弹幕
$getdans = $_GET['id'];
$fgetpath = 'dans/'.$getdans.'.json';
if (!empty($getdans)) {
    $fget = fopen($fgetpath,'a');
    fclose($fget);
    $data = file_get_contents($fgetpath);
    header('Content-Type:application/json');
    echo '{"code":0,"data":['.$data.']}';
}
//接受（POST）数组，写入
//判断并获取元数据
$postdansinput = file_get_contents('php://input');
$postdansarr = json_decode($postdansinput,true);
//转码为php数组
$fpath = 'dans/'.$postdansarr['id'].'.json';
$postdansarr['player'] = array($postdansarr['player']);
//自增
$_id = md5("dplayer".time());
$inputdata = array($postdansarr['time'],0,$postdansarr['color'],$postdansarr['author'],$postdansarr['text']);
//修改存储格式
$returndata = array(
    "_id" => $_id,
    "player" => $postdansarr['id'],
    "author" => $postdansarr['author'],
    "time" => $postdansarr['time'],
    "text" => $postdansarr['text'],
    "color" > $postdansarr['color'],
    "type" => 0,
    "ip" => $postdansarr['author'],
    "referer" => $_SERVER['HTTP_REFERER'],
    "date" => time(),
    "__v" => 0
);
//修改存储格式
$returndata = json_encode($returndata, JSON_UNESCAPED_UNICODE);
//转回json数组，保持UNICODE编码
$postdans = json_encode($inputdata, JSON_UNESCAPED_UNICODE);
//转回json数组，保持UNICODE编码
$postdans = stripslashes($postdans);
//去除转义字符
$lastdata = file_get_contents($fpath).','.$postdans;
//添加逗号分隔
$latestdata = ltrim($lastdata,',');
//去除左边的逗号
//并发写入问题
if ($fw = fopen($fpath, 'w')) {
    $startTime = microtime();
    do {
        $canWrite = flock($fw, LOCK_EX);
        if (!$canWrite)
            usleep(round(rand(0, 100) * 1000));
    }
    while ((!$canWrite) && ((microtime() - $startTime) < 1000));
    if ($canWrite) {
        fwrite($fw, $latestdata);
    }
    fclose($fw);
}

if ($postdansinput) {
    echo '{"code":0,"data":['.$returndata.']}';
}
if (empty($_GET) && empty($postdansinput)) {
    echo "请带参数访问";
}