<?php
use yii\helpers\Url;

$link = Url::toRoute(['/confirmation/confirm', 'token' => $user->confirmation_token], true);
$login_link = Url::toRoute(['/account/session'], true);
?>

Thank you sor sign up!

Your account settings

<?= $login_link ?>
e-mail: <?= $user->email ?>
password: <?= $password ?>


To continue use this link:
<?= $link ?>
