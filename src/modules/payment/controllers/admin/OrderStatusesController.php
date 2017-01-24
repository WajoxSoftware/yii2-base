<?php
namespace wajox\yii2base\modules\admin\controllers;

use wajox\yii2base\models\Order;
use wajox\yii2base\models\OrderStatus;
use wajox\yii2base\models\UploadedFile;
use wajox\yii2base\services\uploads\UploadsManager;
use yii\web\NotFoundHttpException;
use wajox\yii2base\services\order\OrdersManager;
use wajox\yii2base\services\bill\BillsManager;

class OrderStatusesController extends ApplicationController
{
    public function actionCreate($id, $status)
    {
        $request = $this->getApp()->request;
        $success = false;

        $user = $this->getUser();
        $order = $this->findOrder($id);
        $model = $this->createObject(UploadedFile::className());
        $modelStatus = $this->createObject(OrderStatus::className());

        if ($request->isPost) {
            $model = $this->uploadFile($request);
            $this->updateStatus($order, $status);
            $modelStatus = $this->buildStatus($order, $model, $request);

            if (!$modelStatus->isNewRecord) {
                $this->showFile($model->id);
                $success = true;
            }
        }

        return $this->renderJs('create', [
            'model' => $model,
            'modelStatus' => $modelStatus,
            'modelOrder' => $order,
            'success' => $success,
        ]);
    }

    protected function uploadFile($request)
    {
        $model = $this->getUploadsManager()->save($request);

        return $model;
    }

    protected function showFile($fileId)
    {
        $this->getUploadsManager()->show($fileId);
    }

    protected function updateStatus($order, $action)
    {
        $method = $action.'Status';

        $this->$method($order);
    }

    protected function buildStatus($model, $uploadedFile, $request)
    {
        $status = $this
            ->getRepository()
            ->find(OrderStatus::className())
            ->where([
                'order_id' => $model->id,
            ])
            ->orderBy('[[created_at]] DESC')->one();

        $status->load($request->post());

        if (!$uploadedFile->isNewRecord) {
            $status->uploaded_file_id = $uploadedFile->id;
        }

        $status->save();

        return $status;
    }

    protected function findOrder($id)
    {
        $model = $this
            ->getRepository()
            ->find(Order::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function cancelledStatus($model)
    {
        return $this->getBillsManager()->cancelled($model->bill);
    }

    protected function paidStatus($model)
    {
        return $this->getBillsManager()->paid($model->bill);
    }

    protected function returnMoneyStatus($model)
    {
        return $this->getBillsManager()->returned($model->bill);
    }

    protected function preparedStatus($model)
    {
        return $this->getOrdersManager()->prepared($model);
    }

    protected function sendStatus($model)
    {
        return $this->getOrdersManager()->send($model);
    }

    protected function undeliveredStatus($model)
    {
        return $this->getOrdersManager()->undelivered($model);
    }

    protected function deliveredStatus($model)
    {
        return $this->getOrdersManager()->delivered($model);
    }

    protected function returnedStatus($model)
    {
        return $this->getOrdersManager()->returned($model);
    }

    protected function getUploadsManager()
    {
        return $this->createObject(UploadsManager(), [$this->getUser()]);
    }

    protected function getOrdersManager()
    {
        return $this->getDependency(OrdersManager::className());
    }

    protected function getBillsManager()
    {
        return $this->getDependency(BillsManager::className());
    }
}
