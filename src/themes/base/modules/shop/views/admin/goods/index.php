<?php
use yii\helpers\Url;
use yii\widgets\ListView;
use wajox\yii2base\models\Good;

if ($categoryId == 0) {
    $this->title = \Yii::t('app/admin', 'Nav Goods and Categories');
} else {
    $this->params['breadcrumbs'][] = [
    'label' => \Yii::t('app/admin', 'Nav Goods and Categories'),
    'url' => ['index'],
  ];

    foreach ($category->parents as $parentCategory) {
        $this->params['breadcrumbs'][] = [
      'label' => $parentCategory->title,
      'url' => ['index', 'id' => $parentCategory->id],
    ];
    }

    $this->title = $category->title;
}

$this->params['breadcrumbs'][] = $this->title;

if ($categoryId
    && $categoriesDataProvider->totalCount == 0
) {
    $this->params['pageControls']['items'][] = [
      'url' => ['create', 'suffix' => '.js', 'id' => $category->id, 'typeId' => Good::TYPE_ID_ELECTRONIC],
      'title' => \Yii::t('app/general', 'Add Electronic Good'),
      'icon' => 'fa-plus',
      'class' => 'js-remote-link',
    ];

    $this->params['pageControls']['items'][] = [
      'url' => ['create', 'suffix' => '.js', 'id' => $category->id, 'typeId' => Good::TYPE_ID_PHYSICAL],
      'title' => \Yii::t('app/general', 'Add Physical Good'),
      'icon' => 'fa-plus',
      'class' => 'js-remote-link',
    ];

    $this->params['sort'] = [
      'items' => [
          'id',
          'user_id',
          'status_id',
          'good_type_id',
          'title',
          'url',
          'sum',
          'updated_at',
          'created_at',
      ],
      'sort' => $sort,
  ];

    echo ListView::widget([
    'layout' => '<ul class="collection">{items}</ul><div>{pager}</div>',
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
  ]);
} elseif ($dataProvider->totalCount == 0
    || !$categoryId
) {
    $this->params['pageControls']['items'][] = [
    'url' => ['/shop/admin/good-categories/create', 'id' => $categoryId, 'suffix' => '.js'],
    'title' => \Yii::t('app/general', 'Add Good Category'),
    'icon' => 'fa-plus',
    'class' => 'js-remote-link',
  ];

    echo $this->render('_categories', [
      'dataProvider' => $categoriesDataProvider,
    ]);
}
