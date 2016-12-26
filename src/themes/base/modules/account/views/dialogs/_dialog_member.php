<?php
$model = $model ?: new \wajox\yii2base\models\User();
?>

<li class="media">

    <div class="media-body">

        <div class="media">
            <a class="pull-left" href="#">
                <img class="media-object img-circle " style="max-height:50px;" src="<?= $model->avatarUrl ?>" />
            </a>
            <div class="media-body" >
               <strong><?= $model->name ?></strong><br/>
            </div>
        </div>

    </div>
</li>
