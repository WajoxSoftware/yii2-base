<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Добро пожаловать!';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Добро пожаловать!</h1>

        <p>
        	<a href="<?= Url::toRoute(['/admin']) ?>" class="btn btn-primary btn-lg">Панель администратора</a>
        </p>
        <p>
        	<a href="<?= Url::toRoute(['/partner']) ?>" class="btn btn-primary btn-lg">Кабинет партнера</a>
        </p>
        <p>
        	<a href="<?= Url::toRoute(['/account']) ?>" class="btn btn-primary btn-lg">Личный кабинет</a>
        </p>
        <p>
        	<a href="<?= Url::toRoute(['/trafficmanager']) ?>" class="btn btn-primary btn-lg">Панель трафик-менеджера</a>
		</p>
    </div>
</div>
