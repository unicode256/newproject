<?php
Ulogin(1);
Head('Ваш профиль', '#');
?>
<a href="account/logout">Выйти</a><br />
<h2>Ваш профиль:</h2>

<?php
echo '123';
echo 'Ваше имя: ' . $_SESSION['user_name'] . '<br />';
echo 'Ваш email: ' . $_SESSION['user_email'] . '<br />';
echo $_SESSION['user_log_in'];
messageShow();
Footer();
?>