<?php
use yii\widgets\ListView;

$this->title = \Yii::t('app/profile', 'Nav Contacts');
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs', ['current' => 'find']);
?>

<?= $this->render('_search', ['model' => $searchModel]) ?>

<ul class="media-list">
  <?= ListView::widget([
      'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
      'dataProvider' => $dataProvider,
      'itemView' => '_search_contact',
      'viewParams' => ['sentRequests' => $sentRequests],
    ]);
  ?>
</ul>
