<?php
use wajox\yii2base\helpers\GoodsHelper;

$originalPrice = $model->sum;
$deliveryPrice = GoodsHelper::getDeliveryPrice($model);
$price = GoodsHelper::getPartnerPrice($model, \Yii::$app->visitor->partner);
?>

<div class="hidden-xs hidden-sm">
	<p class="good-price">
		<p><?= \Yii::t('app/attributes', 'Price') ?>:</p>
		<?php if ($originalPrice > $price): ?>
			<s>
				<?= $originalPrice ?>Р
			</s>
			<br/>
		<?php endif; ?>
		<span style="font-size: 32px; font-weight: bold;">
			<?= $price ?>Р
		</span>
	</p>

	<?php if ($deliveryPrice > 0): ?>
		<p class="delivery-price">
			<?= \Yii::t('app/attributes', 'Delivery Sum') ?><br/>
			+<?= $deliveryPrice ?>Р	
		</p>
	<?php endif; ?>
</div>

<div class="hidden-md hidden-lg">
	<p class="good-price">
		<p><?= \Yii::t('app/attributes', 'Price') ?>:
		<strong><?= $price ?>Р</strong>
		<?php if ($originalPrice > $price): ?>
			<s><?= $originalPrice ?>Р</s><br/>
		<?php endif; ?>
	</p>

	<?php if ($deliveryPrice > 0): ?>
		<p class="delivery-price">
			<?= \Yii::t('app/attributes', 'Delivery Sum') ?><br/>
			+<?= $deliveryPrice ?>Р	
		</p>
	<?php endif; ?>
</div>
