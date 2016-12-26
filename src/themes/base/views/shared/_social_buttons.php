<?php
use yii\helpers\Url;

$uloginUrl = Url::toRoute(['/' .$moduleId . '/session/ulogin'], true);
?>

<div id="uLogin" data-ulogin="display=panel;fields=first_name,last_name;optional=photo;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=<?= urlencode($uloginUrl) ?>"></div>
<script src="//ulogin.ru/js/ulogin.js"></script>
