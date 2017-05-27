<?php
use yii\helpers\Url;

?>

<h1>Вопрос по счету #<?= $bill->id ?></h1>

<p>
Отправитель: <?= $bill->customer->name ?> <<?= $bill->customer->email ?>>
</p>
<p>
  Вопрос: <?= $question ?>
</p>

