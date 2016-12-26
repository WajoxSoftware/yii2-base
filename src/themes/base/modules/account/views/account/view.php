<?php
use yii\helpers\Url;

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = $this->title;

if ($writeMessageAccess) {
    $this->params['pageControls']['items'][] = [
    'title' => \Yii::t('app/general', 'Write'),
    'url' => [
        '/profile/dialogs/create',
        'userIds' => $model->id,
    ],
    'icon' => 'fa-envelope-o',
  ];
}

if ($contactsManager->canSendRequestTo($model)) {
    $this->params['pageControls']['items'][] = [
    'title' => \Yii::t('app/general', 'Send Contact Request'),
    'url' => [
        '/profile/contact-requests/create',
        'id' => $model->id,
        'suffix' => '.js',
    ],
    'icon' => 'fa-user-plus',
    'class' => 'js-remote-link',
  ];
}
?>

<div class="row">
  <div class="col-md-8">
    <?php if ($viewAccess): ?>
      <?= $this->render('_info', [
          'model' => $model,
        ]); ?>
    <?php endif; ?>
  </div>
  <div class="col-md-4">
    <?php if ($viewContactsAccess): ?>
      <?= $this->render('_contacts', ['model' => $model]); ?>
    <?php endif; ?>
  </div>
</div>
