<?php
?>
Заказ #<?= $order->id ?>
=====================================================
<?php foreach ($goods as $good): ?>


<?= $good->title ?>
=====================================================

Ваша покупка доступна в Вашем личном кабинете!
_____________________________________________________


<?php endforeach; ?>

=====================================================
Благодарим Вас за покупку!