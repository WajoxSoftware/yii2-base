<div class="media-bg">
	<div class="text-center">
		<i class="fa fa-link fa-4x"></i>
	</div>

	<div class="media-descr">
		<?= $model->description ?>
	</div>
	<div class="media-controls">
		<a href="<?= $model->fileUrl ?>"><?= \Yii::t('app', 'Follow this link') ?></a>
	</div>
</div>
