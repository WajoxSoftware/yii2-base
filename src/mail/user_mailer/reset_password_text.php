<?php
use yii\helpers\Url;

$login_link = Url::toRoute(['/account/session'], true);
?>
Your password was changed

Account settings

<?= $login_link ?>
e-mail: <?= $user->email ?>
password: <?= $password ?>
