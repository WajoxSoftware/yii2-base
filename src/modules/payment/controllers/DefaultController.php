<?php
namespace wajox\yii2base\modules\payment\controllers;

use yii\web\NotFoundHttpException;
use wajox\yii2base\modules\payment\models\Bill;
use wajox\yii2base\modules\payment\models\form\BillQuestionForm;

class DefaultController extends ApplicationController
{
    public function actionIndex(int $id)
    {
        $bill = $this->findBill($id);
        $questionForm = $this->buildQuestionForm($bill);
        $questionSend = false;

        $isCashMethod = $this
            ->getApp()
            ->systemPaymentSettings
            ->isCashMethod($bill->payment_method);

        if ($isCashMethod) {
            return $this->redirect([
                '/payment/callbacks',
                'method' => $bill->payment_method,
                'action' => 'waiting',
                'id' => $bill->id,
            ]);
        }

        if ($this->getApp()->request->isPost) {
            $questionSend = $this->sendQuestionForm($questionForm);
        }

        return $this->render('index', [
            'bill' => $bill,
            'questionForm' => $questionForm,
            'questionSend' => $questionSend,
        ]);
    }

    public function actionStatus(int $id)
    {
        $bill = $this->findBill($id);

        return $this->render('status', ['bill' => $bill]);
    }

    private function findBill(int $id)
    {
        return $this->findModelById(Bill::className(), $id);
    }

    private function sendQuestionForm(BillQuestionForm $form)
    {
        return $form->send($this->getApp()->request);
    }

    private function buildQuestionForm(Bill $bill): BillQuestionForm
    {
        $form = $this->createObject(BillQuestionForm::className());
        $form->setBill($bill);

        return $form;
    }
}
