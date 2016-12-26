<?php
use yii\helpers\Url;
$link = Url::toRoute(['/confirmation/confirm', 'token' => $user->confirmation_token], true);
$login_link = Url::toRoute(['/profile/session'], true);
?>
<h1>Благодарим Вас за регистрацию</h1>

<h4>Данные для доступа к Вашему аккаунту</h4>
<p>
  <a href="<?= $login_link ?>"><?= $login_link ?></a><br/>
  e-mail: <?= $user->email ?><br/>
  пароль: <?= $password ?><br/>
</p>

<p>Для продолжения работы подтвердите свой электронный почтовый адрес перейдя по ссылке ниже:</p>
<p><a href="<?= $link ?>" target="_blank"><?= $link ?></a></p>
