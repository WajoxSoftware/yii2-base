<?php
use yii\helpers\Url;

$link = Url::toRoute(['/confirmation/confirm', 'token' => $user->confirmation_token], true);
$login_link = Url::toRoute(['/profile/session'], true);
?>
<h1>Thank you sor sign up!</h1>

<h4>Your account settings</h4>
<p>
  <a href="<?= $login_link ?>"><?= $login_link ?></a><br/>
  e-mail: <?= $user->email ?><br/>
  password: <?= $password ?><br/>
</p>

<p>To continue use this link:</p>
<p><a href="<?= $link ?>" target="_blank"><?= $link ?></a></p>
