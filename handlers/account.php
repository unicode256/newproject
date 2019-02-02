<?php
if($module == 'registration' and $_POST['submit']){
    if(!$_POST['name'] ||! $_POST['email'] || !$_POST['password']){
        messageSend('Надо заполнить всю форму');
    }
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `email` FROM `users` WHERE `email` = '$email'"));
    if($row['email']){
        messageSend('Этот адрес уже существует');
    }
    mysqli_query($CONNECT,"INSERT INTO `users` VALUES ('', '$name', '$email', '$password')");
}
?>