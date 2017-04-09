<?php
$this->title = $emailList->title;
?>

<div class="row">
  <div class="col m12">
    <h1 class="text-muted text-center"><?= $emailList->title ?></h1>
    <h6 class="text-lead text-center"><?= $emailList->description ?></h6>
  </div>
</div>
<div class="subscribe-create">
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
