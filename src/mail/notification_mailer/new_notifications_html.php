<?php
use yii\helpers\Url;
?>

<h1>You have new notifications</h1>

<ul>
<?php foreach ($notifications as $notification): ?>
	<li><?= $notification->subject ?></li>
<?php endforeach; ?>
</ul>

<p>
  You can look for updates in your personal profile by link:
  <br/>
  <?php $url = Url::toRoute(['/profile/notifications'], true) ?>
  <a href="<?= $url ?>"><?= $url ?></a>
</p>
