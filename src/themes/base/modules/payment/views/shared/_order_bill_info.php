<tr>
  <td><?= \Yii::t('app/attributes', 'Status') ?></td>
  <td><?= $order->status ?></td>
</tr>

<tr>
  <td><?= \Yii::t('app/attributes', 'Delivery Status') ?></td>
  <td><?= $order->deliveryStatus ?></td>
</tr>

<tr>
  <td><?= \Yii::t('app/shop', 'Shopping Cart') ?></td>
  <td>
    <?php foreach ($order->goods as $good): ?>
      <p><?= $good->title ?></p>
    <?php endforeach; ?>
  </td>
</tr>
