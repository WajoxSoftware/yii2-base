<?php
use yii\widgets\LinkPager;

$members = array_shift($members);
$membersCount = sizeof($members);
$firstMember = current($members);

if ($membersCount == 1) {
    $dialogTitle = \Yii::t('app/dialogs', 'Dialog With {name}', ['name' => $firstMember->name]);
} else {
    $dialogTitle = \Yii::t('app/dialogs', 'Group Dialog');
}

$this->title = $dialogTitle;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/dialogs', 'Dialogs List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['pageControls']['items'][] = [
  'title' => \Yii::t('app/dialogs', 'Leave Dialog'),
  'url' => ['delete', 'id' => $model->id],
  'icon' => 'fa-sign-out',
];

?>

<div class="row">
  <div class="col m8">
    <div class="message-form messages-form">
      <?= $this->render('_message_form', [
        'dialog' => $model,
        'model' => new \wajox\yii2base\models\Message(),
      ]); ?>
    </div>

    <?php if ($pages->totalCount == 0): ?>
      <center>
        <?= \Yii::t('app/dialogs', 'No messages in this dialog'); ?>
      </center>
    <?php else: ?>
      <ul class="media-list js-messages-list dialog-messages">
        <?php
          foreach ($messages as $message) {
              $member = null;
              if ($message->user_id == \Yii::$app->user->id) {
                  $member = \Yii::$app->user->identity;
              }
              if (isset($members[$message->user_id])) {
                  $member = $members[$message->user_id];
              }

              $member = $member ?: new \wajox\yii2base\models\User();

              echo $this->render('_dialog_message', [
                'model' => $message,
                'user' => $member,
              ]);
          }
        ?>
      </ul>

      <?= LinkPager::widget([
          'pagination' => $pages,
      ]); ?>
    <?php endif; ?>
  </div>
  <?php if ($membersCount > 1): ?>
    <div class="col m4">
      <?= $this->render('_dialog_members', ['models' => $members]) ?>
    </div>
  <?php endif; ?>
</div>
