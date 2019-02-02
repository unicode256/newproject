<?php
Head('Регистрация');
?>
<p>На ваш адреc эл почты отправлено письмо о подтверждении регистрации</p>
<form action="account/confirmation">
<input type="submit" name="confirmed" value="Я подтвердил Регистрацию">
<input type="submit" name="no_message" value="Я не получил письмо">
</form>

<?php
MessageShow();
Footer();
?>