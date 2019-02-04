<?php
//Ulogin(0);
Head('Регистрация', '#');
?>

<h1>Заполните форму чтобы зарегистрироваться</h1>
<form action="account/registration" method="post">
    имя<input name="name" type="text"><br />
    почта<input name="email" type="text"><br />
    пароль<input name="password" type="password"><br />
    <input type="submit" name="submit" value="зарегистрироваться">
</form>

<?php
messageShow();
Footer();
?>