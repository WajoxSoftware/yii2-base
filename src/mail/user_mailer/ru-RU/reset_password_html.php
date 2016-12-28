<?php
use yii\helpers\Url;

$login_link = Url::toRoute(['/profile/session'], true);
?>
<h1>Ваш пароль изменен</h1>

<h4>Данные для доступа к Вашему аккаунту</h4>

<p>
<a href="<?= $login_link ?>"><?= $login_link ?></a><br/>
e-mail: <?= $user->email ?><br/>
пароль: <?= $password ?><br/>
</p>
