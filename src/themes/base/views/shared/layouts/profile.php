<?php
use yii\helpers\Html;
use yii\helpers\Url;
use wajox\yii2widgets\sidebarwidget\SidebarWidget;

$header = isset($header) ? $header : '@app/views/shared/_profile_header';
$pageHeader = isset($pageHeader) ? $pageHeader : '@app/views/shared/_profile_page_header';

$pageContent = isset($pageContent) ? $pageContent : '@app/views/shared/_profile_content';

$footer = isset($footer) ? $footer : '@app/views/shared/_profile_footer';

$appAssetClass = isset($appAssetClass) ?  $appAssetClass : 'wajox\yii2base\themes\base\assets\ProfileAsset';

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
<body data-base-url="<?= Url::home()?>" class="dashboard-body">

<?php $this->beginBody() ?>
    <header data-page-loaded="true" class="hidden">
      <?php
      if (isset($sidebarWidgetOptions)) {
          echo SidebarWidget::widget($sidebarWidgetOptions);
      }
      ?>
      <?= $this->render($header) ?>
    </header>
    <main>
        <div data-page-loading="true">
            <div class="page-loading preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only center">
                  <div class="circle-clipper left">
                    <div class="circle"></div>
                  </div><div class="gap-patch">
                    <div class="circle"></div>
                  </div><div class="circle-clipper right">
                    <div class="circle"></div>
                  </div>
                </div>
            </div>
        </div>
        <div data-page-loaded="true" class="hidden container-fluid">
            <?= $this->render('@app/views/shared/_flash') ?>
            <?= $this->render($pageHeader) ?>
            <?= $this->render($pageContent, [
              'content' => $content,
            ]) ?>
        </div>
    </main>
    <!--<footer data-page-loaded="true" class="hidden">
      <?= $this->render($footer) ?>
    </footer>-->
    <?= $this->blocks['filter-modal'] ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
