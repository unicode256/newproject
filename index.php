<?php
echo 'hello<br />';
$url = str_replace("newproject/", "", $_SERVER['REQUEST_URI']);
//$url = substr($_SERVER['REQUEST_URI'], 1);
var_dump($url);
    if($url/*_SERVER['REQUEST_URI']*/ == '/'){
        $page = 'index';
        $module = 'index';
    }
    else {
        $url_path = parse_url($url/*$_SERVER['REQUEST_URI']*/, PHP_URL_PATH);
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
echo '<br />';
var_dump($url_path);
echo '<br />';
if($page == 'index' && $module == 'index') echo 'Main page';
else if ($page == 'photos') echo 'photos';
else if ($page == 'messages') echo 'messages';
else if ($page == 'news') echo 'news';
?>