<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\search\UserSearch;
use wajox\yii2base\helpers\ViewTypesHelper;

class EmployeesController extends UsersController
{
    public function actionIndex($listingViewType = ViewTypesHelper::VIEW_TYPE_LIST)
    {
        $sort = $this->getSort();
        $searchModel = $this->createObject(UserSearch::className());
        $dataProvider = $searchModel->employeeSearch($this->getApp()->request->queryParams, null, $sort);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sort' => $sort,
            'listingViewType' => $this->getListingViewType($listingViewType),
        ]);
    }
}
