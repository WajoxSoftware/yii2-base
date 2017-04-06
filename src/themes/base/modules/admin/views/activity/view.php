<?php
$this->title = $model->actionTitle;
$this->params['breadcrumbs'][] = [
    'url' => ['index'],
    'label' => \Yii::t('app/admin', 'Nav Activity'),
];
$this->params['breadcrumbs'][] = $this->title;

$user = $model->getUser();
?>

<p class="text-muted">
	<i class="fa fa-calendar"></i> <?= $model->createdDateTime ?>

	<i class="fa fa-link"></i> <?= $model->request_uri; ?>

	<i class="fa fa-map-marker "></i> <?= $model->geo ?>
</p>

<?php if ($user != null): ?>
	<h6><?= \Yii::t('app/models', 'User') ?></h6>
	<?= $this->render('_user', ['model' => $user]); ?>
<?php endif; ?>

<?php if ($model->isOrderAction): ?>
	<h6><?= \Yii::t('app/models', 'Order') ?></h6>
	<?= $this->render('_order', ['model' => $model->getOrder()]); ?>
<?php endif; ?>

<?php if ($model->isBillAction): ?>
	<h6><?= \Yii::t('app/models', 'Bill') ?></h6>
	<?= $this->render('_bill', ['model' => $model->getBill()]); ?>
<?php endif; ?>

<?php if ($model->isGoodAction): ?>
	<h6><?= \Yii::t('app/models', 'Good') ?></h6>
	<?= $this->render('_good', ['model' => $model->getGood()]); ?>
<?php endif; ?>

<?php if ($model->isSubscribeAction): ?>
	<h6><?= \Yii::t('app/models', 'EmailList') ?></h6>
	<?= $this->render('_subscribe', ['model' => $model->getEmailList()]); ?>
<?php endif; ?>

<?php if ($model->isVisitAction): ?>
	<h6><?= \Yii::t('app/models', 'Statistic') ?></h6>
	<?= $this->render('_visit', ['model' => $model->getVisit()]); ?>
<?php endif; ?>

<h6><?= \Yii::t('app/models', 'Logs') ?></h6>
<?= $this->render('@app/modules/admin/views/shared/users/_actions_list', ['dataProvider' => $dataProvider]); ?>
