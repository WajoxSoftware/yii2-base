<?php
use yii\helpers\Url;

$this->title = $model->title;

$this->params['breadcrumbs'][] = [
    'label' => \Yii::t('app/admin', 'Nav Traffic tunnels'),
    'url' => ['index'],
];

$this->params['breadcrumbs'][] = $this->title;

$this->params['pageControls']['items'][] = [
  'url' => [
    '/admin/traffic-tunnels/update',
    'id' => $model->id,
    'suffix' => '.js',
  ],
  'title' => \Yii::t('app/general', 'Update'),
  'icon' => 'edit',
  'class' => 'js-remote-link',
];

$this->params['pageControls']['items'][] = [
  'url' => [
    '/admin/traffic-tunnel-steps/create',
    'id' => $model->id,
    'suffix' => '.js',
  ],
  'title' => \Yii::t('app/general', 'Add {model}', [
    'model' => \Yii::t('app/models', 'TrafficTunnelStep'),
  ]),
  'icon' => 'add',
  'class' => 'js-remote-link',
];

if ($listing->back) {
    $this->params['pageControls']['items'][] = [
    'url' => array_merge(['view', 'id' => $model->id], $listing->back),
    'title' => \Yii::t('app/general', 'Back'),
    'icon' => 'arrow_back',
    'class' => 'js-arrow-left',
  ];
}
?>

<?php if (sizeof($model->steps) > 0): ?>
  <div>
    <?php if ($listing->items): ?>
        <ul class="list list-inline">
          <?php foreach ($listing->items as $item): ?>
            <li><a href="<?= Url::toRoute(array_merge(['view', 'id' => $model->id], $item['urlParams'])) ?>"><?= $item['title'] ?></a></li>
          <?php endforeach; ?>
        </ul>
    <?php endif; ?>
  </div>
  <div>
    <?= $this->render('_steps', [
      'stepsData' => $stepsData,
      'sourceData' => $sourcesData,
      'steps' => $model->steps,
    ]); ?>
  </div>
  <div>
    <?php
    if ($dataProvider) {
        echo \yii\widgets\LinkPager::widget([
        'pagination' => $dataProvider->pagination,
      ]);
    }
    ?>
  </div>
<?php else: ?>
    <center><?= \Yii::t('app/general', 'No data') ?></center>
<?php endif; ?>
