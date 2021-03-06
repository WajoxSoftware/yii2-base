<?php
use yii\helpers\Url;

?>
<li class="media">
    <div class="media-body">
        <div class="media">

            <a class="pull-left" href="<?= $model->viewUrl; ?>">
                <img class="media-object img-circle" style="max-height:50px;" src="<?= $model->avatarUrl ?>" />
            </a>
            <div class="media-body">
                <p>
                    <strong>
                      <?= $model->fullName ?>
                    </strong>
                </p>
                <p>
                    <a href="<?= Url::toRoute(['/account/user-contacts/delete', 'id' => $model->id, 'suffix' => '.js']); ?>" class="btn btn-default btn-xs js-remote-link">
                        <i class="fa fa-user-times"></i>
                        <?= \Yii::t('app/general', 'Delete') ?>
                    </a>
                </p>
            </div>
        </div>
    </div>
</li>
