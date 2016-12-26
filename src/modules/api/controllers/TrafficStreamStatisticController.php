<?php
namespace wajox\yii2base\modules\api\controllers;

use yii\filters\AccessControl;
use wajox\yii2base\services\traffic\TrafficStreamStatisticAnalyzer;
use wajox\yii2base\models\TrafficStream;

class TrafficStreamStatisticController extends ApplicationController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $params = [];
        $request = $this->getApp()->request;
        $interval = $request->post('interval', 'all');
        $s_date = $request->post('custom_start_date', null);
        $f_date = $request->post('custom_finish_date', null);
        $ids = $request->post('id', []);

        $userSubaccountsIds = $this->getUserSubaccountsIds();

        if (sizeof($ids) == 0
            || $ids == null
        ) {
            $this->renderJson('index', ['items' => $items]);
        }

        $ids = is_array($ids) ? $ids : [intval($ids)];

        if (sizeof($userSubaccountsIds) > 0) {
            $params['user_subaccount_id'] = $userSubaccountsIds;
        }

        $items = $this->getStat($ids, $interval, $s_date, $f_date, $params);

        return $this->renderJson('index', ['items' => $items]);
    }

    protected function getStat($ids, $interval, $startDate, $finishDate, $params)
    {
        $items = [];

        foreach ($ids as $id) {
            $model = TrafficStream::findOne(intval($id));

            if ($model != null) {
                $stat = $this->createObject(
                    TrafficStreamStatisticAnalyzer::className(),
                    [$model, $interval, $startDate, $finishDate, $params]
                );
                $items[] = [
                        'id' => $model->id,
                        'stat' => $stat->compute(),
                    ];
            }
        }

        return $items;
    }

    protected function getUserSubaccountsIds()
    {
        $userSubaccountsIdsString = $this->getApp()->request->post('user_subaccounts_ids', null);

        if ($userSubaccountsIdsString == null) {
            return [];
        }

        $ids = [];

        foreach (explode(',', $userSubaccountsIdsString) as $id) {
            if (is_numeric($id)) {
                $ids[] = intval($id);
            }
        }

        return $ids;
    }
}
