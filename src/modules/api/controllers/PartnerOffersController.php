<?php
namespace wajox\yii2base\modules\api\controllers;

use yii\filters\AccessControl;
use wajox\yii2base\models\Good;
use wajox\yii2base\models\GoodPartnerProgram;

class PartnerOffersController extends ApplicationController
{
    const LIMIT = 30;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['partner'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($query = null, $id = null)
    {
        if ($id != null) {
            return $this->actionView($id);
        }

        $programQuery = $this
            ->getRepository()
            ->find(GoodPartnerProgram::className())
            ->where([
                'partner_id' => [0, $this->getPartner()->id],
            ])->joinWith([
                'good' => function ($goodQuery) use ($query) {
                        $goodQuery = $goodQuery->andWhere([
                            'status_id' => Good::STATUS_ID_ACTIVE,
                            'partner_status_id' => Good::PARTNER_STATUS_ID_ACTIVE,
                        ]);

                        if ($query != null) {
                            $goodQuery = $goodQuery->andWhere([
                                'like', 'title', $query,
                            ]);
                        }

                        return $goodQuery;
                    },
            ]);

        $models = $programQuery->limit(self::LIMIT)
                ->indexBy('id')
                ->all();

        return $this->renderJson('index', ['models' => $models]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->renderJson('view', ['model' => $model]);
    }

    protected function findModel($id)
    {
        $model = $this
            ->getRepository()
            ->find(GoodPartnerProgram::className())
            ->where([
                'id' => $id,
                'partner_id' => [0, $this->getPartner()->id],
            ])
            ->one();

        if ($model !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function getPartner()
    {
        $user = $this->getApp()->user->identity;
        if ($user->isPartner) {
            return $user->partner;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
