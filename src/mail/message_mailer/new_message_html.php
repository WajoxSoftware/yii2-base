<?php
use yii\helpers\Url;
$link = Url::toRoute(['/profile/messages/view', 'id' => $message->id], true);
?>
<h1>You have new message!</h1>
<p>From: <?= $message->sender_data()['name']; ?></p>
<p><?= $message->content ?></p>
<p>View more <a href="<?= $link ?>">in your account</a></p>
