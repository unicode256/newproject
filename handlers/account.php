<?php

if($module == 'logout' and $_SESSION['user_log_in'] == 1){
    if($_COOKIE['user']){
        setcookie('user', '', strtotime('-30 days'), '/');
        unset($_COOKIE['user']);
    }
    session_unset();
    exit(header('Location: /login'));
}

Ulogin(0);

if ($module == 'restore' and $_POST['submit']){
    if(!$_POST['email']){
        messageSend('Вы не написали ваш адрес эл. почты');
    }
    $email = formChars($_POST['email']);
    if(!preg_match("#^([-a-z0-9!$%&'*+/=?^_`{|}~]+(?:\.[-a-z0-9!$%&'*+/=?^_`{|}~]+)*@(?:[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])?\.)+(?:aero|arpa|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel|ru|com|by))$#", $email)){
        messageSend('Некорректный адрес электронной почты');
    }
    $res_of_query = mysqli_query($CONNECT, "SELECT `email` FROM `USERS` WHERE `email` = '$email'");
    $row = mysqli_fetch_array($res_of_query);
    if(mysqli_num_rows($res_of_query) == 0){
        messageSend('Пользователь не найден');
    }
    $enc_email = str_replace("=", "", base64_encode($email));
    $sec_code_decoded = rand(11000, 30000);
    $sec_code = str_replace("=", "", base64_encode($sec_code_decoded));
    $result = mail($email, "Восстановление", "Чтобы восстановить пароль, перейдите на страницу восстановления по ссылке: antidating.xyz/account/restore/em/$enc_email/code/$sec_code");
        if(!$result){
            messageSend('не получилось отправить письмо((((');
        }
        else {
            mysqli_query($CONNECT, "UPDATE `USERS` SET `sec_code` = '$sec_code_decoded' WHERE `email` = '$email'");
            messageSend('На указанный адрес высланы интсрукции для восстановления пароля.');
        }
}

else if ($module == 'restore' and $param['em'] and $param['code'] and $_POST['submit_changes']){
    if(!$_POST['password'] or !$_POST['password_repeat']){
        messageSend('Заполните пожалуйста все поля');
    }
    $email = base64_decode($param['em']);
    $sec_code = base64_decode($param['code']);
    $new_sec_code = rand(30001, 60000);
    $password = formChars($_POST['password']);
    $password_repeat = formChars($_POST['password_repeat']);
    if($password != $password_repeat){
        messageSend('Пароли не совпадают');
    }
    mysqli_query($CONNECT, "UPDATE `USERS` SET `password` = '$password' WHERE `email` = '$email' AND `sec_code` = '$sec_code'");
    mysqli_query($CONNECT, "UPDATE `USERS` SET `sec_code` = '$new_sec_code' WHERE `email` = '$email'");
    echo 'Ваш пароль успешно изменен. <a href="/login">Войти</a>';
}

else if ($module == 'restore' and $param['em'] and $param['code']){
    $email = base64_decode($param['em']);
    $sec_code = base64_decode($param['code']);
    $res_of_query = mysqli_query($CONNECT, "SELECT `email` FROM `USERS` WHERE `email` = '$email' AND `sec_code` = '$sec_code'");
    $row = mysqli_fetch_array($res_of_query);
    if(mysqli_num_rows($res_of_query) == 0){
        echo 'сори такой страницы не существует(((';
    }
    else {
        echo 'Смена пароля<br />
        <form action="/account/restore/em/' . $param['em'] . '/code/' . $param['code'] . '" method="post">
            Введите новый пароль:<br />
            <input type="password" name="password"><br />
            Введите новы пароль повторно:<br />
            <input type="password" name="password_repeat"><br />
            <input type="submit" name="submit_changes">
        </form>';
        if(!messageShow()){
            echo messageShow();
        }
    }
}


if ($module == 'registration' and $_POST['submit']){
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
    $row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT `email` FROM `USERS` WHERE `email` = '$email'"));
    if($row['email']){
        messageSend('Этот адрес уже существует');
    }
    mysqli_query($CONNECT, "INSERT INTO `USERS` (`activation`, `name`, `email`, `password`) VALUES (0, '$name', '$email', '$password')");
    if(!$CONNECT){
        messageSend('Ошибка: ' . mysqli_error());
    }
    if(mysqli_error($CONNECT)){
        exit(mysqli_error($CONNECT));
    }
    $enc_email = str_replace("=", "", base64_encode($email));
    $result = mail($email, "Conformation", "Чтобы подтвердить перейдите по ссылке: http://antidating.xyz/account/confirm/email/$enc_email");
    if(!$result){
        messageSend('не получилось отправить письмо((((');
    }
    messageSend('Регистрация заврешена, на указанный емаил отправлено письмо для подтверждения регистрации');
}

else if($module == 'confirm' and $param['email']){
    $enc_email = $param['email'];
    $email = base64_decode($enc_email);
    $result = mysqli_query($CONNECT, "SELECT `activation`, `name` FROM `USERS` WHERE `email` = '$email'");
    $row = mysqli_fetch_array($result);
    if(mysqli_num_rows($result) == 0){
        echo 'сори, такой страницы не существует((';
    }
    else if($row['activation'] == 0){
        mysqli_query($CONNECT, "UPDATE `USERS` SET `activation` = 1 WHERE `email` = '$email'");
        echo '<p>' . $row['name'] . ', спасибо за регистрацию. Теперь вы можете <a href="/login">войти</a></p>';
    }
    else if($row['activation'] == 1){
        echo '<p>' . $row['name'] . ', регистрация вашего аккаунта уже была подтверждена. <a href="/login">Войти</a></p>';
    }
}

else if($module = 'login' and $_POST['submit']){
    $email = formChars($_POST['email']);
    $password = formChars($_POST['password']);
    if(!$_POST['email'] || !$_POST['password']){
        messageSend('Вы не написали емаил или пароль');
    }
    $row = mysqli_fetch_array(mysqli_query($CONNECT, "SELECT * FROM `USERS` WHERE `email` = '$email'"));
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

    if($_REQUEST['remember']){
        setcookie('user', $password, strtotime('+30 days'), '/');
    }

    exit(header('Location: /profile'));
}

?>