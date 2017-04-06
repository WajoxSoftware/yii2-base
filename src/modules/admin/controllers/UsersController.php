<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\User;
use wajox\yii2base\models\search\UserSearch;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use wajox\yii2base\helpers\ViewTypesHelper;

class UsersController extends ApplicationController
{
    public function actionIndex($listingViewType = ViewTypesHelper::VIEW_TYPE_LIST)
    {
        $sort = $this->getSort();
        $searchModel = $this->createObject(UserSearch::className());
        $dataProvider = $searchModel->usersSearch($this->getApp()->request->queryParams, null, $sort);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sort' => $sort,
            'listingViewType' => $this->getListingViewType($listingViewType),
        ]);
    }

    public function actionMap($id)
    {
        return $this->render('map', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionStatistics($id)
    {
        $model = $this->findModel($id);

        $dataProvider = $this->createObject(ActiveDataProvider::className(), [[
            'query' => $model->getLogs(),
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]]);

        return $this->render('statistics', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = $this->createObject(User::className());
        $model->created_at = time();
        $model->guid = md5(uniqid(time(), true));

        if ($model->load($this->getApp()->request->post()) && $model->save()) {
            $this->saveRole($model);

            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load($this->getApp()->request->post()) && $model->save()) {
            $this->saveRole($model);

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        return $this->findModelById(User::className(), $id);
    }

    protected function saveRole($user)
    {
        $this->getApp()->usersManager->saveRole($user);
    }

    protected function getSort()
    {
        return $this->createObject(Sort::className(), [[
            'attributes' => [
                'id' => ['label' => \Yii::t('app/attributes', 'ID')],
                'email' => ['label' => \Yii::t('app/attributes', 'Email')],
                'first_name' => ['label' => \Yii::t('app/attributes', 'First Name')],
                'last_name' => ['label' => \Yii::t('app/attributes', 'Last Name')],
                'name' => ['label' => \Yii::t('app/attributes', 'Login')],
                'created_at' => ['label' => \Yii::t('app/attributes', 'Created At')],
            ],
        ]]);
    }
}
