<?php

$this->title = $model->title;
?>

<div class="row">
	<div class="col-md-12">
		<h1><?= $model->title ?></h1>
	</div>
</div>

<div class="row">
	<div class="col-md-8">
		<?= $this->render('_good_images', ['model' => $model]) ?>
	</div>
	<div class="col-md-4">
		<?= $this->render('_good_pricing', ['model' => $model]) ?>
		<?= $this->render('_good_buttons', ['model' => $model]) ?>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<?= $this->render('_good_content', ['model' => $model]) ?>
	</div>
</div>
