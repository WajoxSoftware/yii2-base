<?php
$this->title = $emailList->title;
?>

<div class="row">
  <div class="col m12">
    <h1 class="text-muted text-center"><?= $emailList->title ?></h1>
  </div>
</div>

<?php if ($success): ?>
    <p><?= \Yii::t('app/general', 'You subscribed successfully') ?></p>
    <?php if ($redirect): ?>
        <p><?= \Yii::t('app/general', 'Please wait, you will be redirected') ?></p>
        <script type="text/javascript">
            setTimeout(function(){
                window.location.href = decodeURIComponent('<?= $redirect ?>');    
            }, 1500);
        </script>
    <?php endif; ?>
<?php else: ?>
    <div class="subscribe-create">
        <?= $this->render('_form', ['model' => $model]) ?>
    </div>
<?php endif; ?>