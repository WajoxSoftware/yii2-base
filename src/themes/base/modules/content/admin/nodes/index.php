<?php
use yii\helpers\Url;
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = $this->title;

if ($parentNode == null) {
    $this->title =  \Yii::t('app/admin', 'Nav Content Nodes');
} else {
    $this->params['breadcrumbs'][] = [
        'label' =>  \Yii::t('app/admin', 'Nav Content Nodes'),
        'url' => ['index'],
      ];

    foreach ($parentNode->parents as $pNode) {
        $this->params['breadcrumbs'][] = [
          'label' => $pNode->title,
          'url' => ['index', 'id' => $pNode->id],
        ];
    }

    $this->title = $parentNode->title;
}

$this->render('_controls', ['parentNode' => $parentNode]);

?>

<ul class="media-list">
  <?php echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
  ]); ?>
</ul>
