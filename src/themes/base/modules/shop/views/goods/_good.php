<?php
use yii\helpers\Url;
use wajox\yii2base\modules\shop\helpers\GoodsHelper;

$originalPrice = $model->sum;
$deliveryPrice = GoodsHelper::getDeliveryPrice($model);
$price = GoodsHelper::getPartnerPrice($model, \Yii::$app->visitor->partner);
?>
<div class="row">
	<div class="col m12">
		<h6>
			<a href="<?= Url::toRoute(['/shop/goods/view', 'url' => $model->url]) ?>"><?= $model->title ?></a>
			<strong><?= $price ?>Р</strong>
			<?php if ($originalPrice > $price): ?>
				<s><?= $originalPrice ?>Р</s><br/>
			<?php endif; ?>
		</h6>
		<p><?= $model->description ?></p>

		<?php if ($deliveryPrice > 0): ?>
			<p class="delivery-price">
				<?= \Yii::t('app/attributes', 'Delivery Sum') ?><br/>
				+<?= $deliveryPrice ?>Р	
			</p>
		<?php endif; ?>
	</div>
</div>
