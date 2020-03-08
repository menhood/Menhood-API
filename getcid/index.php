<?php
header("Access-Control-Allow-Origin: *");
$url=$_GET['url'];
$pregbangumi='|/bangumi/play/(.*?)|i';
$pregvideo='|/video/av(.*?)|i';
ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');
if (preg_match($pregbangumi,$url)){
    $info=file_get_contents("compress.zlib://".$url);
    preg_match('|"epList":(.*?),"epInfo"|i',$info,$m);
    // $m_array = json_encode($m[1],true);
    $m_array = json_decode($m[1],true);
    foreach ( $m_array as $k ){
        echo "集数：".$k['titleFormat']."\n";
        echo "标题：".$k['longTitle']."\n";
        echo "cid：".$k['cid']."\n";
    }
    // $info=file_get_contents($url);
    // preg_match('|"cid":(.*?),"cover"|i',$info,$m);
    // echo $m[1];
}elseif (preg_match($pregvideo,$url)) {
    $info=file_get_contents("compress.zlib://".$url);
    preg_match('|"cid":(.*?),"dimension":|i',$info,$m);
    echo $m[1];    
}else{
    echo "不支持此地址解析";
}
?>