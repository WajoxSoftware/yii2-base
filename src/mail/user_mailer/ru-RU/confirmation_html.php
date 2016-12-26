<?php
use yii\helpers\Url;
$link = Url::toRoute(['/confirmation/confirm', 'token' => $user->confirmation_token], true);
?>
<h1>Подтвердите e-mail</h1>

<p>Подтвердите свой электронный почтовый адрес перейдя по ссылке ниже</p>
<p><a href="<?= $link ?>" target="_blank"><?= $link ?></a></p>
