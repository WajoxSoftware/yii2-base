<?php
use yii\helpers\Url;
?>

You have new notifications
=====================================================

<?php foreach ($notifications as $notification): ?>
* <?= $notification->subject ?>

<?php endforeach; ?>

=====================================================

You can look for updates in your personal profile by link

<?= Url::toRoute(['/profile/notifications'], true) ?>
