<?php
use yii\helpers\Url;

?>

<h1>Question for bill #<?= $bill->id ?></h1>

<p>
Author: <?= $bill->customer->name ?> <<?= $bill->customer->email ?>>
</p>
<p>
  Question: <?= $question ?>
</p>

