<?php
use yii\helpers\Url;

$this->title = \Yii::t('app/profile', 'Nav Home');

$user = \Yii::$app->user->identity;
?>

<div class="row">
  <div class="col s12 m4 l3">
    <div class="card">
      <div class="card-image waves-effect waves-block waves-light">
        <img class="activator" src="<?= $user->avatarUrl ?>">
      </div>
      <div class="card-content">
        <span class="card-title activator grey-text text-darken-4"><?= $user->name ?><i class="material-icons right">more_vert</i></span>
        <p><?= $user->getAttributeLabel('role') ?>: <?= $user->roleName ?></p>
        <p>
          <a href="<?= Url::to(['/account/settings']) ?>"><i class="material-icons">edit</i></a>
          <a href="<?= $user->viewUrl ?>"><i class="material-icons">person</i></a>
        </p>
      </div>
      <div class="card-reveal">
        <span class="card-title grey-text text-darken-4"><?= $user->name ?><i class="material-icons right">close</i></span>
        <p><?= $user->getAttributeLabel('name') ?>: <?= $user->name ?></p>
        <p><?= $user->getAttributeLabel('first_name') ?>: <?= $user->first_name ?></p>
        <p><?= $user->getAttributeLabel('last_name') ?>: <?= $user->last_name ?></p>
        <p><?= $user->getAttributeLabel('email') ?>: <?= $user->email ?></p>
        <p><?= $user->getAttributeLabel('phone') ?>: <?= $user->phone ?></p>
        <p><?= $user->getAttributeLabel('gender') ?>: <?= $user->gender ?></p>
        <p><?= $user->getAttributeLabel('role') ?>: <?= $user->roleName ?></p>
        <p><?= $user->getAttributeLabel('created_at') ?>: <?= $user->createdDateTime ?></p>
        <p>
          <a href="<?= Url::toRoute(['/account/bills/create']) ?>"><?= $user->getAttributeLabel('account_balance') ?>: <?= $stat['account_balance'] ?> P</a>
        </p>
        <p>
          <a href="<?= Url::toRoute(['/account/dialogs']) ?>">
            Cообщения:
            <?php if ($stat['unread_messages'] == 0): ?>
             Нет новых
            <?php elseif ($stat['unread_messages'] % 10 == 1): ?>
              <?= $stat['unread_messages'] ?> новое
            <?php else: ?>
              <?= $stat['unread_messages'] ?> новых
            <?php endif ?>
          </a>
        </p>
      </div>
    </div>          
  </div>
</div>
