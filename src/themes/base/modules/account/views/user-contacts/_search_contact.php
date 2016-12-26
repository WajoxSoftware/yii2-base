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
            </div>
            <p>
                <?php if (isset($sentRequests[$model->id])): ?>
                    <span class="text-muted"><?= \Yii::t('app', 'Contact Request Sent') ?></span>
                <?php else: ?>
                    <a href="<?= Url::toRoute(['/account/contact-requests/create', 'id' => $model->id, 'suffix' => '.js']); ?>" class="btn btn-default btn-xs js-remote-link">
                        <i class="fa fa-user-plus"></i>
                        <?= \Yii::t('app', 'Send Contact Request') ?>
                    </a>
                <?php endif; ?>
            </p>
        </div>
    </div>
</li>
