<?php
namespace wajox\yii2base\modules\shop\controllers\admin;

use wajox\yii2base\modules\admin\controllers\ApplicationController as AdminApplicationController;

class DefaultController extends AdminApplicationController
{
    public function actionIndex()
    {
        return $this->redirect(['/shop/admin/goods']);
    }
}
