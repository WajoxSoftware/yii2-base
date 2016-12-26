<?php

$this->title = \Yii::t('app/admin', 'Nav Activity');
$this->params['breadcrumbs'][] = $this->title;

$this->params['filter'] = [
  'model' => $searchModel,
  'items' => ['userName', 'referalUserName', 'actionTitle'],
  'body' => $this->render('_search_form', ['model' => $searchModel]),
];

//echo $this->render('_search_form', ['model' => $searchModel]);
echo $this->render('@app/modules/admin/views/shared/users/_actions_list', ['dataProvider' => $dataProvider]);
