<?php
use yii\widgets\LinkPager;

$this->title = \Yii::t('app/dialogs', 'Dialogs List');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/dialogs', 'Dialogs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if ($pages->totalCount == 0): ?>
  <center>
    <?= \Yii::t('app/dialogs', 'No dialogs'); ?>
  </center>
<?php else: ?>
  <ul class="media-list">
    <?php
      foreach ($models as $model) {
          $dialogId = $model->dialog_id;
          $modelMembers = isset($members[$dialogId]) ? $members[$dialogId] : [];
          $message = isset($messages[$dialogId]) ? $messages[$dialogId] : null;

          echo $this->render('_user_dialog', [
            'model' => $model,
            'members' => $modelMembers,
            'message' => $message,
          ]);
      }
    ?>
  </ul>
  <div>
    <?php

      echo LinkPager::widget([
          'pagination' => $pages,
      ]);
    ?>
  </div>
<?php endif; ?>
