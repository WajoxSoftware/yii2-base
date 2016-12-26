<?php
?>
Order #<?= $order->id ?>
=====================================================
<?php foreach ($goods as $good): ?>


<?= $good->title ?>
=====================================================
You can access your purchases in your profile
_____________________________________________________


<?php endforeach; ?>

=====================================================
Thank you for using our service!
