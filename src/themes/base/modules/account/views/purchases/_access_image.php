<div class="media-bg">
	<img src="<?= $model->fileUrl ?>" style="max-width: 100%;"/>
	<div class="media-descr">
		<?= $model->description ?>
	</div>
	<div class="media-controls">
		<a href="<?= $model->fileUrl ?>"><?= \Yii::t('app/general', 'Download') ?></a>
	</div>
</div>
