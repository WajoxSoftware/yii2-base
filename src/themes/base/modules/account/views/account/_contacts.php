<?php if (sizeof($model->contacts) > 0): ?>
	<ul class="media-list">
		<?php foreach ($model->contacts as $userContact): ?>
			<?= $this->render('_contact', [
                    'model' => $userContact->contactUser,
                ]); ?>
		<?php endforeach; ?>
	</ul>
<?php else: ?>
	<?= \Yii::t('app/general', 'No data'); ?>
<?php endif; ?>
