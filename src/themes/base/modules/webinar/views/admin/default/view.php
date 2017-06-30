<?php
$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col m6">
        <?= $this->render('_info', ['model' => $model]) ?>
    </div>

    <div class="col m6">
        <?= $this->render('_messages', ['model' => $model]) ?>
    </div>
</div>