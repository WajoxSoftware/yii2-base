<?php
use yii\helpers\Url;

?>

<li><a href="<?= Url::toRoute(['/shop/goods/index', 'url' => $model->url]) ?>"><?= $model->title ?></a></li>
