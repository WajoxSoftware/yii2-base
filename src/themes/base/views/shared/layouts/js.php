<?php
$appAssetClass = isset($appAssetClass) ?  $appAssetClass : 'wajox\yii2base\assets\AppAsset';
call_user_func([$appAssetClass, 'register'], $this);

echo  $content;

ob_start();
$this->beginPage();
$this->beginBody();
$this->head();
$this->endBody();
$this->endPage();
$headers = rawurlencode(ob_get_clean());
?>

window.App.importAssets(decodeURIComponent('<?= $headers ?>'));
