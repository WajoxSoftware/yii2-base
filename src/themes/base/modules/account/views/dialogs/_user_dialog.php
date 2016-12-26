<?php
use yii\helpers\Url;
use wajox\yii2base\helpers\TextHelper;

$membersCount = sizeof($members);
$firstMember = current($members);

if ($membersCount == 1) {
    $dialogTitle = \Yii::t('app/dialogs', 'Dialog With {name}', ['name' => $firstMember->name]);
} else {
    $dialogTitle = \Yii::t('app/dialogs', 'Group Dialog');
}

$dialogDate = date('d.m.Y H:i', $model->updated_at);

$messageAuthor = null;
if ($message && isset($members[$message->user_id])) {
    $messageAuthor =  $members[$message->user_id];
}

?>


<li class="media">
    <div class="media-body">

        <div class="media">
            <a class="pull-left" href="#">
                <img class="media-object img-circle" style="max-height:40px;" src="<?= $firstMember->avatarUrl ?>" />
            </a>
            <div class="media-body" >

	             <strong><?= $dialogTitle ?></strong><br/>

               <?php if ($message !== null): ?>
                   <small><?= TextHelper::shorter($message->content) ?></small><br/>
               <?php endif; ?>
               <small class="text-muted">
                  <?php if ($messageAuthor !== null):?>
                    <span><?= \Yii::t('app/dialogs', 'Message From {name}', ['name' => $messageAuthor->name]) ?></span> |
                  <?php endif; ?>
               	  <?= $dialogDate ?> |
                  <a href="<?= Url::toRoute(['/account/dialogs/view', 'id' => $model->dialog_id]) ?>"?><?= \Yii::t('app/dialogs', 'View Dialog') ?></a>
               </small>
               <hr />
            </div>
        </div>
    </div>
</li>
