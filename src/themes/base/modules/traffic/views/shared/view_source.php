<?php
use yii\helpers\Url;
use yii\widgets\ListView;

if ($source->hasParentSource) {
    $this->params['breadcrumbs'][] = [
      'label' => $source->parentSource->title,
      'url' => ['view-source', 'id' => $source->parent_source_id],
    ];
}

$this->params['breadcrumbs'][] = $source->title;

if (!$source->hasStreams && !$source->hasParentSource) {
    $this->params['pageControls']['items'][] = [
    'url' => [
      '/traffic/traffic-sources/create',
      'id' => $user->id,
      'parentId' => $source->id,
      'suffix' => '.js',
    ],
    'title' => \Yii::t('app/general', 'Add {model}', [
      'model' => \Yii::t('app/models', 'TrafficSource'),
    ]),
    'icon' => 'fa-plus',
    'class' => 'js-remote-link',
  ];
}

if (!$source->hasSources || $source->hasParentSource) {
    $this->params['pageControls']['items'][] = [
    'url' => [
      '/traffic/traffic-streams/create',
      'id' => $source->id,
      'suffix' => '.js',
    ],
    'title' => \Yii::t('app/general', 'Add {model}', [
      'model' => \Yii::t('app/models', 'TrafficStream'),
    ]),
    'icon' => 'fa-plus',
    'class' => 'js-remote-link',
  ];

    $this->params['filter'] = [
    'model' => $searchModel,
    'items' => ['datesInterval', 'userSubaccount'],
    'body' => $this->render('@app/modules/traffic/views/shared/_search_form', ['model' => $searchModel]),
  ];
}

?>

<?php if ($source->hasSources): ?>
  <div>
    <?= ListView::widget([
      'dataProvider' => $dataProvider,
      'itemView' => '@app/modules/traffic/views/shared/_source_item',
    ]); ?>
  </div>
<?php elseif ($source->hasStreams): ?>
  <div data-traffic-stream-interval-filter="<?= $searchModel->interval ?>" data-traffic-stream-startdate-filter="<?= $searchModel->startDate ?>" data-traffic-stream-finishdate-filter="<?= $searchModel->finishDate ?>" data-traffic-stream-user-subaccounts-filter="<?= $searchModel->userSubaccountIds; ?>">
    <?= ListView::widget([
      'dataProvider' => $dataProvider,
      'itemView' => '@app/modules/traffic/views/shared/_stream_item',
    ]); ?>
  </div>

  <?= $this->render('@app/modules/traffic/views/shared/_traffic_stream_statistic_js'); ?>
  <?= $this->render('@app/modules/traffic/views/shared/_subaccounts_link_generator'); ?>
<?php endif; ?>
