<?php
use yii\helpers\Url;

?>
  <div class="card">
    <div class="center card-image waves-effect waves-block waves-light">
      <i class="material-icons large">ondemand_video</i>
    </div>
    <div class="card-content">
      <span class="card-title activator grey-text text-darken-4">
        <?= $model->title ?>
        <i class="material-icons right">more_vert</i>
      </span>
      <p>
        <?= $model->start_datetime ?>
        -
        <?= $model->finish_datetime ?>
      </p>
      <p><a href="<?= Url::to(['/webinar/default/view', 'id' => $model->id]) ?>" target="_blank"><?=\Yii::t('app/general', 'View') ?></a></p>
    </div>
    <div class="card-reveal">
      <span class="card-title grey-text text-darken-4">
        <?= $model->title ?>
        <i class="material-icons right">close</i>
      </span>
      <p>
        <?= $model->start_datetime ?>
        -
        <?= $model->finish_datetime ?>
      </p>
    </div>
  </div>