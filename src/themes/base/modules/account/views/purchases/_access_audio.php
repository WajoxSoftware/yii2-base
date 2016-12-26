<div class="media-bg">
	<audio src="<?= $model->fileUrl ?>" controls></audio>
	<div class="media-descr">
		<?= $model->description ?>
	</div>
	<div class="media-controls">
		<a href="<?= $model->fileUrl ?>"><?= \Yii::t('app/general', 'Download') ?></a>
	</div>
</div>
