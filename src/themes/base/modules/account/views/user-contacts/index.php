<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/profile', 'Nav Contacts');
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs', ['current' => 'index']);
?>

<ul class="media-list">
  <?= ListView::widget([
      'dataProvider' => $dataProvider,
      'itemView' => '_user_contact',
    ]);
  ?>
</ul>
