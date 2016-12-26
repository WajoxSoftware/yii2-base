<?php
namespace wajox\yii2base\modules\partner\controllers;

use wajox\yii2base\models\Partner;
use wajox\yii2base\models\User;

class SettingsController extends ApplicationController
{
    public function actionIndex()
    {
        $request = $this->getApp()->request;
        $success = true;
        $model = $this->getPartnerModel();

        if ($request->isPost) {
            $model->load($request->post());

            if ($model->isNewRecord) {
                $model->parent_partner_id = $this->getApp()->visitor->partnerId;
                $model->created_at = time();
            }

            $model->user_id = $this->getApp()->user->id;
            $model->type_id = Partner::TYPE_ID_CASUAL;

            $success = $model->save();
            if ($success) {
                $message = \Yii::t('app/general', 'User settings was saved');
                $this->getApp()->session->setFlash('success', $message);
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    private function getPartnerModel()
    {
        $model_user = $this->getUser();
        $model = $model_user->partner;

        if ($model == null) {
            $model = $this->createObject(Partner::className());
            $model->user_id = $model_user->id;
        }

        return $model;
    }
}
