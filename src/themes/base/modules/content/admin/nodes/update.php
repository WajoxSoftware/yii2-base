<?php
use yii\helpers\Url;

$this->title = $modelNode->title;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Content Nodes'), 'url' => ['index']];

if ($modelNode->hasParent) {
    foreach ($modelNode->parents as $parentNode) {
        $this->params['breadcrumbs'][] = [
          'label' => $parentNode->title,
          'url' => ['index', 'id' => $parentNode->id],
        ];
    }
}

$this->params['breadcrumbs'][] = $this->title;

$this->params['pageControls']['items'][] = [
  'url' => $modelNode->pageUrl,
  'title' => \Yii::t('app/general', 'View'),
  'icon' => 'fa-eye',
];
?>

<div class="row">
	<div class="col-md-9">
		<?= $this->render('_form', [
            'model' => $model,
            'modelNode' => $modelNode,
        ]); ?>
	</div>

  <div class="col-md-3">
    <?=  $this->render('_preview', ['model' => $modelNode]) ?>
  </div>
</div>
