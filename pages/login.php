<?
Head('Вход', '#');
?>
<h1>Вход</h1>
<form action="account/login" method="post">
    Адрес почты:<br />
    <input type="text" name="email"><br />
    Пароль:<br />
    <input type="password" name="password"><br />
    <input name="submit" type="submit" value="Войти">
</form>
<?
messageShow();
Footer();
?>