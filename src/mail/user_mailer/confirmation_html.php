<?php
use yii\helpers\Url;

$link = Url::toRoute(['/confirmation/confirm', 'token' => $user->confirmation_token], true);
?>
<h1>Confirm your e-mail</h1>

<p>Confirm your email by link</p>
<p><a href="<?= $link ?>" target="_blank"><?= $link ?></a></p>
