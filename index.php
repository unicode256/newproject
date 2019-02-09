<?php
session_start();
include_once 'setting.php';
$CONNECT = mysqli_connect(HOST, USER, PASS, DB);
if(!$CONNECT){
    echo mysqli_error();
}

if($_SESSION['user_log_in'] != 1 and $_COOKIE['user']){
    $password = $_COOKIE['user'];
    $row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `USERS` WHERE `password` = '$password'"));
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];
    $_SESSION['user_email'] = $row['email'];
    $_SESSION['user_log_in'] = 1;
}

$url = str_replace("newproject/", "", $_SERVER['REQUEST_URI']);
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
else if ($page == 'restore') include 'pages/restore.php';
else if ($page == 'users' || $module == 'users') include 'pages/users.php';

function Ulogin($param){
    if($param <= 0 and $_SESSION['user_log_in'] != $param){
        messageSend('Указанная страница доступна только для гостей', '/profile');
    }
    else if ($_SESSION['user_log_in'] != $param){
        messageSend('Указанная страница доступна только для пользователей, чтобы просматривать эту страницу, войдите в свою учётную запись', '/login');
    }
}

function formChars($string){
    return nl2br(htmlspecialchars(trim($string), ENT_QUOTES), false);
}

function Head($title, $style, $param = ''){
    echo '<!DOCTYPE html>
    <html>
        <head>
            <title>' . $title . '</title>
            <meta charset="UTF-8">
            <link href="' . $style . '" type="text/css" rel="stylesheet">
        </head>
        <body>';
        if($param == 1){
            echo '<a href="/profile">Мой профиль</a> | <a href="/users">Пользователи</a> | <a href="account/logout">Выход</a>';
        }
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
    if(!empty($_SESSION['error_message'])){
        $message = $_SESSION['error_message'];
        echo $message;
        $_SESSION['error_message'] = array();
    }
}
?>