
<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use wajox\yii2base\services\users\PrivacySettingsManager;

?>

<?php $form = ActiveForm::begin(); ?>

	<div class="row">
	    <div class="col m12">
	        <?= $form->field($model, 'view_profile')
                ->dropDownList(
                    PrivacySettingsManager::getAccessList()
                ); ?>
	    </div>
	</div>

	<div class="row">
	    <div class="col m12">
	        <?= $form->field($model, 'show_contacts')
                ->dropDownList(
                    PrivacySettingsManager::getAccessList()
                ); ?>
	    </div>
	</div>

	<div class="row">
	    <div class="col m12">
	        <?= $form->field($model, 'search_profile')
                ->dropDownList(
                    PrivacySettingsManager::getAccessListSearch()
                ); ?>
	    </div>
	</div>

	<div class="row">
	    <div class="col m12">
	        <?= $form->field($model, 'add_profile')
                ->dropDownList(
                    PrivacySettingsManager::getAccessListAdd()
                ); ?>
	    </div>
	</div>

	<div class="row">
	    <div class="col m12">
	        <?= $form->field($model, 'message_profile')
                ->dropDownList(
                    PrivacySettingsManager::getAccessListMessage()
                ); ?>
	    </div>
	</div>

	<div class="row">
	    <div class="col m12">
	        <?= $form->field($model, 'send_notifications')->checkbox(); ?>
	    </div>
	</div>

	<div class="row">
	    <div class="col m12">
	        <div class="form-group">
	            <?= Html::submitButton(\Yii::t('app/general', 'Save'), ['class' => 'btn btn-primary btn-block']) ?>
	        </div>
	    </div>

	</div>

<?php ActiveForm::end(); ?>
