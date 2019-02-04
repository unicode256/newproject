<?php
session_start();
include_once 'setting.php';
$CONNECT = mysqli_connect(HOST, USER, PASS, DB) or die ('Ошибка соединения с сервером');
//if($CONNECT) echo 'ok';
//else echo 'no';

$url = str_replace("newproject/", "", $_SERVER['REQUEST_URI']);
//var_dump($url);
    if($url == '/'){
        $page = 'index';
        $module = 'index';
    }
    else {
        $url_path = parse_url($url, PHP_URL_PATH);
        $url_parts = explode('/', trim($url_path, '/'));
        $page = array_shift($url_parts);
        $module = array_shift($url_parts);

        if(!empty($module)){
        $param = array();
        for ($i = 0; $i < count($url_parts); $i++){
            $param[$url_parts[$i]] = $url_parts[++$i];
        }
    }
}

if($page == 'index' && $module == 'index') include 'pages/index.php';
else if ($page == 'registration') include 'pages/registration.php';
else if ($page == 'account') include 'handlers/account.php' ;
else if ($page == 'login') include 'pages/login.php';
else if ($page == 'confirmation') include 'pages/confirmation.php';
else if ($page == 'profile') include 'pages/profile.php';

function Ulogin($param){
    if($param == 1 and empty($_SESSION['user_log_in'])){
        messageSend('Указанная страница доступна только для пользователей, чтобы просматривать эту страницу, войдите в свою учётную запись', '/newproject/login');
    }
    else if ($param == 0 and $_SESSION['user_log_in'] == 1){
        header('Location: /newproject/profile');
    }
}

function formChars($string){
    return nl2br(htmlspecialchars(trim($string), ENT_QUOTES), false);
}

function Head($title, $style){
    echo '<!DOCTYPE html>
    <html>
        <head>
            <title>' . $title . '</title>
            <meta charset="UTF-8">
            <link href="' . $style . '" type="text/css" rel="stylesheet">
        </head>
        <body>';
}

function Footer(){
    echo ' </body>
    </html>';
}

function messageSend($error_msg, $redirect = ''){
    $_SESSION['error_message'] = '<p style="color: red;" class="error">' . $error_msg . '</p>';
    if($redirect){
        $_SERVER['HTTP_REFERER'] = $redirect;
    }
    exit(header('Location: ' . $_SERVER['HTTP_REFERER']));
}

function messageShow(){
    if($_SESSION['error_message']){
        $message = $_SESSION['error_message'];
        echo $message . '<br />' . $_SERVER['HTTP_REFERER'] . '<br />';
        $_SESSION['error_message'] = array();
    }
}
?>