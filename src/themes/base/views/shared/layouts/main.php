<?php
use yii\helpers\Html;
use yii\helpers\Url;

$header = isset($header) ? $header : '@app/views/shared/_header';
$footer = isset($footer) ? $footer : '@app/views/shared/_footer';
$appAssetClass = isset($appAssetClass) ?  $appAssetClass : 'wajox\yii2base\themes\base\assets\AppAsset';
call_user_func([$appAssetClass, 'register'], $this);

$metaTitle = implode(' ', [
    $this->title,
    \Yii::$app->settings->get('app_meta_title'),
]);
$metaKeywords = \Yii::$app->settings->get('app_meta_keywords');
$metaDescription = \Yii::$app->settings->get('app_meta_description');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= \Yii::$app->language ?>">
<head>
    <meta charset="<?= \Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="keywords" content="<?= Html::encode($metaKeywords) ?>"/>
    <meta name="description" content="<?= Html::encode($metaDescription) ?>"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($metaTitle) ?></title>
    <?php $this->head() ?>
</head>
<body data-base-url="<?= Url::home()?>" data-enable-statistic-log="true">

<?php $this->beginBody() ?>
    <div class="wrap">
        <?= $this->render($header) ?>
        <div class="container">
            <?= $this->render('@app/views/shared/_flash') ?>
            <div class="row">
                <div class="col m10 col moffset-1">
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
    <?= $this->render($footer) ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
