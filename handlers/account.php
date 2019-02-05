<?php
//Ulogin(0);
if($module == 'registration' and $_POST['submit']){
    if(!$_POST['name'] ||! $_POST['email'] || !$_POST['password']){
        messageSend('Надо заполнить всю форму');
    }
    $name = formChars($_POST['name']);
    $email = formChars($_POST['email']);
    $password = formChars($_POST['password']);
    if(!preg_match("#^([-a-z0-9!$%&'*+/=?^_`{|}~]+(?:\.[-a-z0-9!$%&'*+/=?^_`{|}~]+)*@(?:[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])?\.)+(?:aero|arpa|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel|ru|com|by))$#", $email)){
        messageSend('Некорректный адрес электронной почты');
    }
    if(!preg_match("#^[0-9a-zA-Z]{6,}#", $password)){
        messageSend('Пароль должен содержать не менее 6 символов');
    }
    else {
        if(!preg_match("#(?=.*[0-9])#", $password)){
            messageSend('Пароль должен содержать хотя бы одну цифру');
        }
        if(!preg_match("#(?=.*[A-z])#", $password)){
            messageSend('Пароль должен содержать хотя бы одну букву в верхнем и одну букву в нижнем регистре');
        }
        if(!preg_match("#(?=.*[a-z])#", $password)){
            messageSend('Пароль должен содержать хотя бы одну латинскую букву в нижнем регистре');
        }
        if(!preg_match("#(?=.*[A-Z])#", $password)){
            messageSend('Пароль должен содержать хотя бы одну латинскую букву в верхнем регистре');
        }
    }
    $row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `email` FROM `users` WHERE `email` = '$email'"));
    if($row['email']){
        messageSend('Этот адрес уже существует');
    }
    mysqli_query($CONNECT, "INSERT INTO `users` (`activation`, `name`, `email`, `password`) VALUES (0, '$name', '$email', '$password')");
    if(mysqli_error($CONNECT)){
        exit(mysqli_error($CONNECT));
    }
    $enc_email = str_replace("=", "", base64_encode($email));
    echo $email;
    $messqge = 'Чтобы подтвердить перейдите по ссылке: localhost/newproject/account/confirm/email/' . $enc_email;
    $reslut = mail($email, 'Confirmation', $enc_email);
    if($result){
        echo 'письмо ушло успешно'; 
    }
    else {
        echo 'не получилось отправить письмо((((';
    }
}

else if($module == 'confirm' and $param['email']){
    $enc_email = $param['email'];
    $email = base64_decode($email);
    $result = mysqli_query($CONNECT, "SELECT `activation` FROM `users` WHERE `email` = '$email'");
    $row = myqli_fetch_array($result);
    if($row['activation'] == 0){
        mysqli_query($CONNECT, "UPDATE `users` SET `activation` = 1 WHERE `email` = '$email'");
        echo '<p>' . $row['name'] . ', спасибо за регистрацию. Теперь вы можете <a href="login">войти</a></p>';
    }
    else if($row['activation'] == 1){
        echo '<p>' . $row['name'] . ', регистрация вашего аккаунта уже была подтверждена. <a href="login">Войти</a></p>';
    }
    else if(mysqli_num_rows($result) == 0){
        echo 'сори, такой страницы не существует((';
    }
}

else if($module = 'login' and $_POST['submit']){
    $email = formChars($_POST['email']);
    $password = formChars($_POST['password']);
    if(!$_POST['email'] || !$_POST['password']){
        messageSend('Вы не написали емаил или пароль');
    }
    $row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `email` = '$email'"));
    if($row['password'] != $password){
        messageSend('Неверный емаил или пароль');
    }
    if($row['activation'] == 0){
        messageSend('Ваша почта не подтверждена, подтвердите плиз');
    }
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];
    $_SESSION['user_email'] = $row['email'];
    $_SESSION['user_log_in'] = 1;
    exit(header('Location: /newproject/profile'));
}
?>