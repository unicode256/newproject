<?php
Ulogin(0);
Head('ANTIDATING | Восстановление', '../resources/styles/login-style.css');
?>
<div id="main">
    <h1 id="logo"><img src="../resources/images/WhiteLogo.png" alt="ANTIDATING"></h1>
    <form action="account/restore" method="post">
        <p id="bottom_line">Восстановление пароля</p>
        <p class="label">Введите ваш адрес эл. почты:</p>
        <input type="text" name="email">
        <input type="submit" name="submit" value="Восстановить">
    </form>
</div>
<div class="footer">
    <div class="fbuttons">
        <a href="" class="fbutton fbutton1">Наши контакты</a>
        <a href="" class="fbutton fbutton2">Наши правила</a>
        <a href="" class="fbutton fbutton3">Наш блог</a>
    </div>
</div>
<?php
messageShow();
Footer();
?>