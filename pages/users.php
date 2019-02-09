<?php
$page = formChars($page);
$module = formChars($module);
if($module == 'users'){
    $page = $page + 0;
}
$draw = "";
if($page == 'users' and !$module){
    $page_title = 'ANTIDATING | Пользователи';
    $result = mysqli_query($CONNECT, "SELECT `id`, `name`, `email` FROM `USERS`");
    while($row = mysqli_fetch_array($result)){
        $draw .= "<p><a href=\"/users/" . $row['id'] . "\">" . $row['name'] . "</a></p>";
    }
}
else if($page == 'users' and $module){
    $id = $module;
    $result = mysqli_query($CONNECT, "SELECT `name`, `email` FROM `USERS` WHERE `id` = '$id'");
    if(mysqli_num_rows($result) == 0){
        exit('сори, такой страницы не существует(((');
    }
    else {
        $row = mysqli_fetch_array($result);
        $draw = '<h2>Профиль пользователя ' . $row['name'] . '<h2>
        его почта: ' . $row['email'];
        $page_title = 'ANTIDATING | Пользователь';
    }
}
Ulogin(1);
Head($page_title, '#', 1);
echo $draw;
footer();
?>