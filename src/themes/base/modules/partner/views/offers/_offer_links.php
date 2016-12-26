<?php
use yii\helpers\Url;
?>
<div class="list-item">
	<div class="row">
	  <div class="col-md-6">
	    <?= \Yii::t('app/attributes', 'Good Order Form Link') ?>
	  </div>

	  <div class="col-md-6">
	    <input type="text" value="<?= Url::toRoute(['/shop/order-forms/good', 'url' => $model->good->url, '_r_id' => $partner->user_id], true) ?>" class="form-control"/>
	  </div>
	</div>
</div>

<div class="list-item">
	<div class="row">
	  <div class="col-md-6">
	  	<?= \Yii::t('app/attributes', 'Good View Page Link') ?>
	  </div>

	  <div class="col-md-6">
	    <input type="text" value="<?= Url::toRoute(['/shop/goods/view', 'url' => $model->good->url, '_r_id' => $partner->user_id], true) ?>" class="form-control"/>
	  </div>
	</div>
</div>
<?php foreach ($model->links as $link): ?>
	<?= $this->render('_link_item', ['model' => $link]); ?>
<?php endforeach; ?>
