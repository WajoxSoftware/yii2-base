<?php
use yii\helpers\Url;
$login_link = Url::toRoute(['/profile/session'], true);
?>
Ваш пароль изменен

Данные для доступа к Вашему аккаунту

<?= $login_link ?>
e-mail: <?= $user->email ?>
пароль: <?= $password ?>
