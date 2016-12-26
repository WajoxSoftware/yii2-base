<?php
$this->title = \Yii::t('app/account', 'Account Settings');
$this->params['breadcrumbs'][] = $this->title;

$this->render('@app/modules/account/views/shared/_tabs', ['current' => 'security']);

?>
<div class="row">
  <div class="col-md-12">
  	<h6><?= \Yii::t('app/account', 'Account Privacy Settings') ?></h6>
    <?= $this->render('_settings_form', ['model' => $modelSettings]) ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
  	<h6><?= \Yii::t('app/account', 'Account Change Password') ?></h6>
    <?= $this->render('_password_form', ['model' => $modelPassword]) ?>
  </div>
</div>
