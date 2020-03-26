<?php
header('Content-type: application/json');

function isAjax() {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        return true;
    } else {
        return false;
    }
}

function isGet() {
    return $_SERVER['REQUEST_METHOD'] == 'GET' ? true : false;
}

function isPost() {
    return ($_SERVER['REQUEST_METHOD'] == 'POST'  && (empty($_SERVER['HTTP_REFERER']) || preg_replace("~https?:\/\/([^\:\/]+).*~i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("~([^\:]+).*~", "\\1", $_SERVER['HTTP_HOST']))) ? 1 : 0;
}

if ($_GET['action'] == 'logout') {
            session_start();
            unset($_SESSION['authorId']);
            unset($_SESSION['username']);
            echo '{"code":0,"msg":"注销成功"}';
            exit();
}

if ($_GET['action'] == 'stat') {
            session_start();
            if (isset($_SESSION['authorId'])){
                echo '{code:0,msg:"已登录"}';
            }else{
                echo '{code:0,msg:"未登录"}';
            }
            
            exit();
        }

if (isPost()) {
    //不存在POST参数用户名时
    if (!isset($_POST['username']) || $_POST['username'] == '') {
        echo  '{"code":1,"msg":"没有用户名！"}';
        exit();
    }
    //不存在POST参数密码时
    if (!isset($_POST['password']) || $_POST['password'] == ''){
        echo  '{"code":1,"msg":"没有密码！"}';
        exit();
    }   
    
    include('conn.php');
    $username = htmlspecialchars($_POST['username']);
    $password = MD5($_POST['password']);

    if (md5($config[$username]['password']) === $password) {
        //登录成功
        session_start();
        $_SESSION['username'] = $config[$username]['name'];
        $_SESSION['authorId'] = $config[$username]['authorId'];
        echo '{"code":0,"msg":"登录成功！\n 欢迎 '.$_SESSION['username'].'"}';
    } else {
        echo '{"code":1,"msg":"密码错误！"}';
    }
    
} else {
    echo '{"code":1,"msg":"请用POST方式访问！"}';
}