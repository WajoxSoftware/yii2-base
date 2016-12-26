<?php
use yii\helpers\Url;
$link = Url::toRoute(['/profile/messages/view', 'id' => $message->id], true);
?>
<h1>У Вас новое сообщение!</h1>
<p>Сообщение от: <?= $message->sender_data()['name']; ?></p>
<p><?= $message->content ?></p>
<p>Подробная информация в <a href="<?= $link ?>">личном кабинете</a></p>
