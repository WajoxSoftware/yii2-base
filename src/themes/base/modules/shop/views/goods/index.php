<?php
use yii\helpers\Url;
use yii\widgets\ListView;

if ($categoryId != 0) {
    foreach ($category->parents as $parentCategory) {
        $this->params['breadcrumbs'][] = [
      'label' => $parentCategory->title,
      'url' => ['index', 'url' => $parentCategory->url],
    ];
    }

    $this->title = $category->title;
}

$this->params['breadcrumbs'][] = $this->title;

if (sizeof($categories) > 0) {
    echo $this->render('_categories', [
    'models' => $categories,
  ]);
}

echo ListView::widget([
  'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
  'dataProvider' => $dataProvider,
  'itemView' => '_good',
]);
