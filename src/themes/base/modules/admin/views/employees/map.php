<?php

use yii\helpers\Url;
use wajox\yii2base\services\web\AddressByIp;
use wajox\yii2base\helpers\DateTimeHelper;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/admin', 'Nav Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->render('_tabs', ['current' => 'map', 'model' => $model]);

/***
* Collecting linked phones and emails
***/

$phones = [];
$emails = [];

if ($model->phone != '') {
    $phones[$model->phone] = '';
}

foreach ($model->customers as $customer) {
    $phones[$customer->phone] = $customer->createdDateTime;
    $emails[$customer->email] = $customer->createdDateTime;
}

foreach ($model->subscribes as $subscribe) {
    $phones[$subscribe->phone] = $subscribe->createdDateTime;
    $emails[$subscribe->email] = $subscribe->createdDateTime;
}

/***
* Compute statistics
***/

$clicks_stat = ['count' => 0, 'first' => \Yii::t('app', 'No data'), 'last' => \Yii::t('app', 'No data')];
$subscribes_stat = ['count' => 0, 'first' => \Yii::t('app', 'No data'), 'last' => \Yii::t('app', 'No data')];
$orders_stat = ['count' => 0, 'sum' => 0.0, 'first' => \Yii::t('app', 'No data'), 'last' => \Yii::t('app', 'No data')];

$subscribes_stat['count'] = $model->getSubscribes()->count();

if ($subscribes_stat['count'] > 0) {
    $subscribes_stat['first'] = $model->getSubscribes()
        ->orderBy('created_at ASC')
        ->offset(0)
        ->limit(1)
        ->one()
        ->createdDateTime;

    $subscribes_stat['last'] = $model->getSubscribes()
        ->orderBy('created_at DESC')
        ->offset(0)
        ->limit(1)
        ->one()
        ->createdDateTime;
}

$orders_stat['count'] = $model->getOrders()->count();

if ($orders_stat['count'] > 0) {
    $orders_stat['sum'] = $model->getOrders()->sum('sum');
    $orders_stat['sum'] += $model->getOrders()->sum('delivery_sum');

    $orders_stat['first'] = $model->getOrders()
        ->orderBy('created_at ASC')
        ->offset(0)
        ->limit(1)
        ->one()
        ->createdDateTime;

    $orders_stat['last'] = $model->getOrders()
        ->orderBy('created_at DESC')
        ->offset(0)
        ->limit(1)
        ->one()
        ->createdDateTime;
}

?>


<div class="row">
    <div class="col-md-12">
        <?php if ($model->isPartner): ?>
            <p>
                <i class="fa fa-male"></i>
                &nbsp;
                <a href="<?= Url::toRoute(['/admin/partners/view', 'id' => $model->partner->id]) ?>"><?= $model->fullName ?></a>
            </p>
        <?php endif; ?>

        <?php if ($model->hasTrafficManager): ?>
            <p>
                <i class="fa fa-male"></i>
                &nbsp;
                <?= $model->fullName ?></a>
            </p>
        <?php endif; ?>

        <?php foreach ($phones as $phone => $date): ?>
            <p>
                <i class="fa fa-phone"></i>
                &nbsp;
                <?= $phone ?>
                <small class="text-muted"><?= $date ?></small>
            </p>
        <?php endforeach; ?>

        <?php foreach ($emails as $email => $date): ?>
            <p>
                <i class="fa fa-at"></i>
                &nbsp;
                <?= $email ?>
                <small class="text-muted"><?= $date ?></small>
            </p>
        <?php endforeach; ?>

        <p>
            <i class="fa fa-building"></i>
            &nbsp;
            <?= AddressByIp::getDetailed($model->ip_address) ?>
        </p>

        <p>
            <i class="fa fa-clock-o"></i>
            &nbsp;
            <?= DateTimeHelper::getLifeTime($model->created_at) ?>
        </p>

        <div>
            <p><i class="fa fa-bar-chart"></i> &nbsp; Подписки</p>
            <p>
                <?= $subscribes_stat['count'] ?> подписок
                | <?= \Yii::t('app', 'First time') ?>: <?= $subscribes_stat['first'] ?>
                | <?= \Yii::t('app', 'Last time') ?>: <?= $subscribes_stat['last'] ?>
            </p>
            <p><i class="fa fa-bar-chart"></i> &nbsp; Покупки</p>
            <p><?= $orders_stat['count'] ?> покупок на сумму <?= $orders_stat['sum'] ?> P
                | <?= \Yii::t('app', 'First time') ?>: <?= $orders_stat['first'] ?>
                | <?= \Yii::t('app', 'Last time') ?>: <?= $orders_stat['last'] ?>
            </p>
        </div>
    </div>
</div>
