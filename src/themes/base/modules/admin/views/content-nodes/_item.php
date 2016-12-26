<?php
use yii\helpers\Url;

?>
<li class="media">

    <div class="media-body">

        <div class="media">
            <a class="pull-left" href="<?= Url::toRoute(['index', 'id' => $model->id]) ?>">
                <img class="media-object img-circle" style="max-height:50px;" src="<?= $model->previewImageThumbUrl ?>" />
            </a>
            <div class="media-body" >
               <a  href="<?= Url::toRoute(['index', 'id' => $model->id]) ?>"><?= $model->title ?></a><br/>
               <small class="text-muted">
                    <a  href="<?= Url::toRoute(['index', 'id' => $model->id]) ?>"><?= \Yii::t('app/general', 'View') ?></a> |
                    <a  href="<?= Url::toRoute(['update', 'id' => $model->id]) ?>"><?= \Yii::t('app/general', 'Edit') ?></a> |
                    <?= $model->type ?> |
                    <?= $model->createdDateTime ?>
               </small>
               <hr />
            </div>
        </div>

    </div>
</li>
