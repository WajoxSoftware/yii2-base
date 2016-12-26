<?php
use wajox\yii2base\helpers\FormHelper;
?>

<div class="row">
  <div class="col-md-6">
    <?= $form->field($model, 'partnerStatusId')->dropDownList(
        $model::getPartnerStatusIdList()
    ); ?>
  </div>

    <div class="col-md-6">
        <?= $form->field($model, 'partnerPartnerId')->dropDownList(
            \wajox\yii2base\helpers\GoodPartnersHelper::getPartnersList()
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <?= FormHelper::renderRurPriceField($form, $model, 'partnerFee1Level') ?>
    </div>
    <div class="col-md-6">
        <?= FormHelper::renderRurPriceField($form, $model, 'partnerFee2Level') ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'partnerLink') ?>
    </div>
</div>