<?php
include_once 'setting.php';
$CONNECT = mysqli_connect(HOST, USER, PASS, DB) or die ('Ошибка соединения с сервером');
if($CONNECT) echo 'ok';
else echo 'no';

$url = str_replace("newproject/", "", $_SERVER['REQUEST_URI']);
var_dump($url);
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

if($page == 'index' && $module == 'index') echo 'Main page';
else if($page == 'registration') include 'registration.php';
else if ($page == 'photos') echo 'photos';
else if ($page == 'messages') echo 'messages';
else if ($page == 'news') echo 'news';

function f($ss){
    echo $ss;
}
?>