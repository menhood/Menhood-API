<?php
if($_GET['k']!=='<test>'){exit('Error! No key!');};
require_once 'aliyun-oss-php-sdk-2.3.1.phar';

if (is_file(__DIR__ . '/../autoload.php')) {
    require_once __DIR__ . '/../autoload.php';
}
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

use OSS\OssClient;
use OSS\Core\OssException;

// 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录 https://ram.console.aliyun.com 创建RAM账号。
$accessKeyId = "<accessKeyId>";
$accessKeySecret = "<accessKeySecret>";
// Endpoint以杭州为例，其它Region请按实际情况填写。
$endpoint = "http://oss-cn-hangzhou.aliyuncs.com";
$bucket = "<bucketname>";

$ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);

$nextMarker = '';

$objects = array();

while (true) {
    try {
        $options = array(
            'delimiter' => '',
            'marker' => $nextMarker,
        );
        $listObjectInfo = $ossClient->listObjects($bucket, $options);
    } catch (OssException $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        return;
    }
    // 得到nextMarker，从上一次listObjects读到的最后一个文件的下一个文件开始继续获取文件列表。
    $nextMarker = $listObjectInfo->getNextMarker();
    $listObject = $listObjectInfo->getObjectList();
    $listPrefix = $listObjectInfo->getPrefixList();

    if (!empty($listObject)) {
        print(date("Y-m-d H:i:s")." objectList:\n");
        foreach ($listObject as $objectInfo) {
            print($objectInfo->getKey() . "\n");
            array_push($objects,$objectInfo->getKey());
            try {
                $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);

                $ossClient->deleteObjects($bucket, $objects);
            } catch (OssException $e) {
                printf(__FUNCTION__ . ": FAILED\n");
                printf($e->getMessage() . "\n");
                return;
            }
            print(__FUNCTION__ . date("Y-m-d H:i:s").": OK" . "\n");
        }
    }
    if (!empty($listPrefix)) {
        print("prefixList:\n");
        foreach ($listPrefix as $prefixInfo) {
            print($prefixInfo->getPrefix() . "\n");
        }
    }
    if ($listObjectInfo->getIsTruncated() !== "true") {
        date_default_timezone_set("Asia/Shanghai");
        echo date("Y-m-d H:i:s")." 无数据！";
        break;
    }
}