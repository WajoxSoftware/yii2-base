<ul class="list list-inline">
	<?php foreach ($models as $model): ?>
		<?= $this->render('_category', ['model' => $model]) ?>
	<?php endforeach; ?>
</ul>
