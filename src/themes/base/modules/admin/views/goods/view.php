<?php
use yii\helpers\Url;

$this->title = $model->getModel()->title;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Goods'), 'url' => ['index']];

if ($model->getModel()->category_id) {
    foreach ($model->getModel()->category->parents as $parentCategory) {
        $this->params['breadcrumbs'][] = [
          'label' => $parentCategory->title,
          'url' => ['index', 'id' => $parentCategory->id],
        ];
    }

    $this->params['breadcrumbs'][] = [
      'label' => $model->getModel()->category->title,
      'url' => ['index', 'id' => $model->getModel()->category_id],
    ];
}

$this->params['breadcrumbs'][] = $this->title;

$this->render('tabs/_tabs', ['current' => $currentTab, 'model' => $model]);

echo $this->render('tabs/' . $currentTab, ['model' => $model]);
