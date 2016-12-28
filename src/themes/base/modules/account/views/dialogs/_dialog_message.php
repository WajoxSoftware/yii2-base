<?php
use wajox\yii2base\helpers\TextHelper;

$user = $user == null ? new \wajox\yii2base\models\User() : $user;
?>

<li class="media">

    <div class="media-body">

        <div class="media">
            <a class="pull-left" href="#">
                <img class="media-object img-circle " style="max-height:50px;" src="<?= $user->avatarUrl ?>" />
            </a>
            <div class="media-body" >
               <?= TextHelper::plain2html($model->content) ?><br/>
               <small class="text-muted">
                    <?= \Yii::t('app/dialogs', 'Message From {name}', ['name' => $user->name]) ?> |
                    <?= $model->statusDate ?></small>
               <hr />
            </div>
        </div>

    </div>
</li>
