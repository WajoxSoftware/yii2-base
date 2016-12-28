<?php
use yii\helpers\Url;

$link = Url::toRoute(['/profile/messages/view', 'id' => $message->id], true);
?>
You have new message!
========================
From: <?= $message->sender_data()['name']; ?>
<?= $message->content ?>
========================
More info in your account:
<?= $link ?>
