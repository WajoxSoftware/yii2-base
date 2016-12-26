<?php
use yii\helpers\Url;

$this->title = \Yii::t('app/profile', 'Nav Home');
?>

<div class="row">
  <div class="col-md-3 col-sm-6">
    <div class="tile">
      <div class="tile-image">
        <i class="fa fa-money"></i>
      </div>

      <h3 class="tile-title">Личный счет</h3>
      <p class="main-text"><?= $stat['account_balance'] ?> P</p>
      <p class="text-link"><a href="<?= Url::toRoute(['/account/bills/create']) ?>" class="btn btn-primary btn-large btn-block">Пополнить счет</a></p>
    </div>
  </div>

  <div class="col-md-3 col-sm-6">
    <div class="tile">
      <div class="tile-image">
        <i class="fa fa-envelope-o"></i>
      </div>

      <h3 class="tile-title">Сообщения</h3>
      <p class="main-text">
            <?php if ($stat['unread_messages'] == 0): ?>
             Нет новых
            <?php elseif ($stat['unread_messages'] % 10 == 1): ?>
              <?= $stat['unread_messages'] ?> новое
            <?php else: ?>
              <?= $stat['unread_messages'] ?> новых
            <?php endif ?>
      </p>
      <p class="text-link"><a href="<?= Url::toRoute(['/account/dialogs']) ?>" class="btn btn-primary btn-large btn-block">Мои сообщения</a></p>
    </div>
  </div>
</div>
