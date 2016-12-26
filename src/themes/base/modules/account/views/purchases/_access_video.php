<div class="media-bg">
	<video controls>
		<source src="<?= $model->fileUrl ?>">
	</video>
	<div class="media-descr">
		<?= $model->description ?>
	</div>
	<div class="media-controls">
		<a href="<?= $model->fileUrl ?>"><?= \Yii::t('app/general', 'Download') ?></a>
	</div>
</div>
