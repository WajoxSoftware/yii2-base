<?php
$signUpView = isset($signUpView) ? $signUpView : '@app/views/shared/_sign_up_form';
$signInView = isset($signInView) ? $signInView : '@app/views/shared/_sign_in_form';
?>
<div class="backdrop">
  <div class="modal modal-fixed" id="login_modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"></div>
        <div class="modal-body">
          <div class="js-sign-up">
            <div class="row">
              <div class="col m12">
                <h3><?= \Yii::t('app/general', 'Sign Up') ?></h3>
                <?= $this->render($signUpView, ['model' => $model_signup]) ?>
              </div>
            </div>
          </div>

          <div class="js-sign-in">
            <div class="row">
              <div class="col m12">
                <h3><?= \Yii::t('app/general', 'Sign In') ?></h3>
                <?= $this->render($signInView, ['model' => $model_signin]) ?>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer"></div>
      </div>
    </div>
  </div>
</div>
