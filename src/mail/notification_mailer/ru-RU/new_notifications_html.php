<?php
use yii\helpers\Url;
?>

<h1>У Вас есть новые уведомления</h1>

<ul>
<?php foreach ($notifications as $notification): ?>
	<li><?= $notification->subject ?></li>
<?php endforeach; ?>
</ul>

<p>
  Вы можете посмотреть все свои уведомления в Вашем личном кабинете:
  <br/>
  <?php $url = Url::toRoute(['/profile/notifications'], true) ?>
  <a href="<?= $url ?>"><?= $url ?></a>
</p>
