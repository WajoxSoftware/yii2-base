<?php
use yii\helpers\Url;
$link = Url::toRoute(['/profile/messages/view', 'id' => $message->id], true);
?>
У Вас новое сообщение!
========================
Сообщение от: <?= $message->sender_data()['name']; ?>
<?= $message->content ?>
========================
Подробная информация в личном кабинете:
<?= $link ?>
