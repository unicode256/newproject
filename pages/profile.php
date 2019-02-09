<?php
Ulogin(1);
Head('Ваш профиль', '#', 1);
?>
<h2>Ваш профиль:</h2>

<?php
echo 'Ваше имя: ' . $_SESSION['user_name'] . '<br />';
echo 'Ваш email: ' . $_SESSION['user_email'] . '<br />';
messageShow();
Footer();
?>