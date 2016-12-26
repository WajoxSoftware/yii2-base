<?php
use yii\helpers\Url;

$this->title = \Yii::t('app/account', 'Account Social Network Accounts');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/account', 'Account Settings'), 'url' => ['/account/settings/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->render('@app/modules/account/views/shared/_tabs', ['current' => 'networks']);
?>

<div class="row">
    <div class="col-md-12">
        <h6><?= \Yii::t('app/account', 'Connect Social Network Account') ?></h6>
        <div id="uLogin" class="well" data-ulogin="display=panel;fields=first_name,last_name;optional=photo;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=<?= urlencode(Url::toRoute(['create'], true)) ?>"></div>
        <script src="//ulogin.ru/js/ulogin.js"></script>
    </div>
</div>
<ul class="media-list">
    <?php foreach ($user->networkAccounts as $model): ?>
        <li class="media">
            <div class="media-body">
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object img-circle " style="max-height:50px;" src="<?= $model->params['photo'] ?>" />
                    </a>
                    <div class="media-body" >
                       <strong>
                            <?= $model->params['first_name'] ?>
                            <?= $model->params['last_name'] ?>
                        </strong><br/>
                        <small class="text-muted">
                            <?= $model->provider ?> |
                            <a href="<?= Url::toRoute(['delete', 'id' => $model->id]) ?>"><?= \Yii::t('app', 'Delete') ?></a>
                        </small>
                        <hr />

                    </div>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
