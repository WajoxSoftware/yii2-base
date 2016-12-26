<?php
?>

<h1>Заказ #<?= $order->id ?></h1>

<?php foreach ($goods as $good): ?>
  <div>
    <h3><?= $good->title ?></h3>
    Ваша покупка доступна в Вашем личном кабинете!
    <br/><br/>
  </div>
<?php endforeach; ?>

<p>Благодарим Вас за покупку!</p>
