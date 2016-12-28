<?php
use yii\helpers\Url;

?>

Your order #<?= $order->id ?> changed
=====================================================

New order status: <?= $order->status ?> / <?= $order->deliveryStatus ?>.

=====================================================

You can look for updates by link

<?= Url::toRoute(['/payment/default/status', 'id' => $order->bill_id], true) ?>
