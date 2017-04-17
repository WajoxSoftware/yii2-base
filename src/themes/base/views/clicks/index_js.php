<?php
use \yii\helpers\Url;

?>
var urlTpl = '<?= Url::to(['/clicks/create', 'url' => 'URL'], true) ?>';
var scriptEl = document.createElement('SCRIPT');
var urlEncoded = encodeURIComponent(window.location.toString());
var endpointUrl = urlTpl.replace('URL', urlEncoded);
scriptEl.setAttribute('src', endpointUrl);
document.body.appendChild(scriptEl);