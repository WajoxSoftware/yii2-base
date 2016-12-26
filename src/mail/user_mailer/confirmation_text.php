<?php
use yii\helpers\Url;
$link = Url::toRoute(['/confirmation/confirm', 'token' => $user->confirmation_token], true);
?>
Confirm your e-mail

Confirm your email by link
<?= $link ?>
