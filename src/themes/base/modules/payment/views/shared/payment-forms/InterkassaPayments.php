<div class="row">
  <div class="col-md-8">
    <h5><?= $method->getTitle() ?></h5>
  </div>

  <div class="col-md-4">
    <form name="payment" method="post" action="https://sci.interkassa.com/" target="_blank"  accept-charset="UTF-8">
      <input type="hidden" name="ik_co_id" value="<?= $id ?>" />
      <input type="hidden" name="ik_pm_no" value="<?= $bill_id ?>" />
      <input type="hidden" name="ik_cur" value="RUB" />
      <input type="hidden" name="ik_am" value="<?= $amount ?>" />
      <input type="hidden" name="ik_desc" value="<?= $description ?>" />
      <input type="submit" value="<?= \Yii::t('app/general', 'Pay') ?>" class="btn btn-primary"/>
    </form>
  </div>
</div>
