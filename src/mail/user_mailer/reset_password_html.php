<?php
use yii\helpers\Url;

$login_link = Url::toRoute(['/profile/session'], true);
?>
<h1>Your password was changed</h1>

<h4>Your account settings</h4>

<p>
<a href="<?= $login_link ?>"><?= $login_link ?></a><br/>
e-mail: <?= $user->email ?><br/>
password: <?= $password ?><br/>
</p>
