<?php
use yii\helpers\Url;

?>

<h1>Статус заказа #<?= $order->id ?> изменен</h1>

<p>
  Новый статус Вашего заказа: <?= $order->status ?> / <?= $order->deliveryStatus ?>.
</p>

<p>
  Вы можете отслеживать статус Вашего заказа по ссылке:
  <br/>
  <?php $url = Url::toRoute(['/payment/default/status', 'id' => $order->bill_id], true) ?>
  <a href="<?= $url ?>"><?= $url ?></a>
</p>
