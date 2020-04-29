<?php
header('Access-Control-Allow-Origin: *');
header("content-type:application/json ;charset=utf-8");
// header("Access-Control-Allow-Headers:x-requested-with,content-type");
header('Access-Control-Allow-Method: *');
// if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
//     exit();
// }
$addtime = 0;
$minustime = 0;
if ($_GET['cid']) {
    $url = "https://api.bilibili.com/x/v1/dm/list.so?oid=".$_GET['cid'];
    $preg_p = '|<d p="(.*?)">|i';
    $preg_d = '|">(.*?)<\/d>|i';
    $preg_id = '|<chatid>(.*?)<\/chatid>|i';
    //ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');
    //$contents = file_get_contents("compress.zlib://".$url);
    // 1. 初始化
$ch = curl_init();
// 2. 设置选项，包括URL
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_HEADER,0);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
// 3. 执行并获取HTML文档内容
$contents = curl_exec($ch);
if($output === FALSE ){
 echo "CURL Error:".curl_error($ch);
}
// 4. 释放curl句柄
curl_close($ch);

    preg_match_all($preg_p,$contents,$p);
    preg_match_all($preg_d,$contents,$d);
    preg_match_all($preg_id,$contents,$id);
    $arrlength = count($p[1]);
    for ($i = 0;$i < $arrlength;$i++) {
        $pieces = explode(",", $p[1][$i]);
        $type = 0;
        if ($pieces[1] === '4') {
            $type = 2;
        } else if ($pieces[1] === '5') {
            $type = 1;
        }
        $time = floatval($pieces[0])+$addtime+$minustime;
        $data .= '['.$time.','. $type.','. $pieces[3].',"'. $pieces[6] .'","'.  str_ireplace(["/","\r\n", "\r", "\n","\""],['|',"","",""," "],$d[1][$i]).'"],';
    }
    $newstr = substr($data,0,strlen($data)-1);
    $fstr = '{"code":0,"data":['.$newstr.']}';
    
} else {
    $fstr = '{"code":1,"data":["没有参数！"]}';
}
echo $fstr;
?>
