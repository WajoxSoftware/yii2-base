<div class="row">
	<div class="col m8 tab-content">
		<?php foreach ($model->entities as $i => $entity): ?>

		    <div id="entity-<?=$i ?>" class="tab-pane fade<?php if ($i == 0): ?> in active<?php endif; ?>">
		        <?= $this->render('_egood_access', ['model' => $entity]); ?>
		    </div>

		<?php endforeach; ?>
	</div>

	<div class="col m4">
		<ul class="nav nav-pills">
			<?= $this->render('_egood_list', ['model' => $model]) ?>
		</ul>
	</div>
</div>
