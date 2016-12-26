<?php
namespace wajox\yii2base\commands;

use yii\console\Controller;
use wajox\yii2base\models\User;
use wajox\yii2base\models\Partner;
use wajox\yii2base\models\PartnerFee;
use wajox\yii2base\services\partner\PartnerFeeManager;
use wajox\yii2base\services\traffic\StatisticComputer;

class PartnersController extends Controller
{
    const FEE_LIFE_TIME = 2592000; // 30 days

    public function actionConfirmFees()
    {
        $fees = PartnerFee::find()->where([
                '<=',
                'created_at',
                time() - self::FEE_LIFE_TIME,
            ])->limit(1000);

        foreach ($fees->each() as $fee) {
            (new PartnerFeeManager)->confirm($fee);
        }
    }

    public function actionUpdateCounters()
    {
        foreach (Partner::find()->with('user')->each() as $partner) {
            $this->updatePartnerCounters($partner);
        }
    }

    protected function updatePartnerCounters($partner)
    {
        $computer = new StatisticComputer($partner->user);
        $items = $computer->fetch(0, time());

        $subscribesCount = $items['newSubscribesCount'];
        $clicksCount = $items['visitsCount'];
        $salesCount = $items['billsCount'];
        $paymentsSum  = $items['partnersFeeSum'];
        $salesSum = $items['billsSum'];

        $partner->subscribes_count = $subscribesCount;
        $partner->clicks_count = $clicksCount;
        $partner->sales_count = $salesCount;
        $partner->payments_sum = $paymentsSum;
        $partner->sales_sum = $salesSum;

        $partner->save();

        return $partner;
    }
}
