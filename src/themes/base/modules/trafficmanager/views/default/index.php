<?php
$this->title = \Yii::t('app/trafficmanager', 'Nav Statistic');
$this->params['filter'] = [
  'model' => $model,
  'items' => ['datesInterval'],
  'body' => $this->render('_statistic_filter_form', [
    'model' => $model,
  ]),
];

echo $this->render('_statistic_cards', [
    'items' => $cardsStat,
]);
