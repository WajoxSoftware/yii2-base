<?php
?>

<h1>Order #<?= $order->id ?></h1>

<?php foreach ($goods as $good): ?>
  <div>
    <h3><?= $good->title ?></h3>
    You can access your purchases in your profile
    <br/><br/>
  </div>
<?php endforeach; ?>

<p>Thank you for using our service!</p>
