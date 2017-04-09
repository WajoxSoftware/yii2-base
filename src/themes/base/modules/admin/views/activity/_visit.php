<?php
?>

<a data-Statistic-id="<?=$model->id ?>" href="#" class="row list-item">
  <div class="col m4">
    <?= $model->page_title ?>
  </div>
  <div class="col m2">
    <?= $model->scroll ?> / <?=$model->screen_size ?>
  </div>

  <div class="col m2">
    <i class="fa fa-clock-o"></i> <?= $model->spend_time ?>
  </div>

  <div class="col m4">
    <?= $model->browser_data ?>
  </div>
</a>
