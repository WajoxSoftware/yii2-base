<?php
use yii\helpers\Url;

?>

<li class="collection-item avatar" data-user-id="<?=$model->id ?>" >
    <i class="material-icons circle">account_box</i>
    <span class="title">
      <a href="<?= Url::toRoute(['view', 'id' => $model->id]) ?>">
        <?= $model->name ?> (<?=$model->email ?>)
      </a>
    </span>

    <p><?= $model->roleName ?></p>
    <p><?=$model->phone ?></p>


    <span class="secondary-content">
    </span>
</li>
