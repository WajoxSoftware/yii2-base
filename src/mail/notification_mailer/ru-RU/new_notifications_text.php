<?php
use yii\helpers\Url;

?>

У Вас есть новые уведомления
=====================================================

<?php foreach ($notifications as $notification): ?>
* <?= $notification->subject ?>

<?php endforeach; ?>

=====================================================

Вы можете посмотреть все свои уведомления в Вашем личном кабинете

<?= Url::toRoute(['/profile/notifications'], true) ?>
