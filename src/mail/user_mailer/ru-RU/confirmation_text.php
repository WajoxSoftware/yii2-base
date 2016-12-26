<?php
use yii\helpers\Url;
$link = Url::toRoute(['/confirmation/confirm', 'token' => $user->confirmation_token], true);
?>
Подтвердите e-mail

Подтвердите свой электронный почтовый адрес перейдя по ссылке ниже
<?= $link ?>
