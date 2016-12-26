<?php
use yii\helpers\Url;
?>

<a href="<?= Url::toRoute(['/shop/order-forms/good', 'url' => $model->url]) ?>" class="btn btn-success btn-lg btn-block"><?= \Yii::t('app/general', 'Order this good') ?></a>
