<?php
use yii\helpers\Url;

$this->title = \Yii::t('app/shop', 'Shopping Cart');
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
	<?php foreach ($cart['items'] as $item): ?>
		<div class="row">
			<div class="col m4"><?= $item['model']->title ?></div>
			<div class="col m4"><?= $item['price'] ?> P x <?= $item['count'] ?></div>
			<div class="col m4"><?= \Yii::t('app/shop', 'Shopping Cart Sum') ?> <?= $item['sum'] ?> P</div>
		</div>
	<?php endforeach; ?>

	<div class="row">
		<div class="col m12"><?= \Yii::t('app/shop', 'Shopping Cart Total Count') ?>: <?= $item['totalCount'] ?></div>
	</div>

	<div class="row">
		<div class="col m12"><?= \Yii::t('app/shop', 'Shopping Cart Total Sum') ?>: <?= $item['totalSum'] ?> P</div>
	</div>
</div>

<div class="row">
	<div class="col m4 col moffset-4">
		<a href="<?= Url::toRoute(['/shop/order/create', 'cart' => $cart['json']]); ?>"><?= \Yii::t('app/general', 'Make Order') ?></a>
	</div>
</div>
