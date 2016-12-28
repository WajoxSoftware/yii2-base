<?php
namespace wajox\yii2base\commands;

use yii\console\Controller;
use wajox\yii2base\models\SettingOption;
use wajox\yii2base\services\settings\SettingsManager;

class SettingsController extends Controller
{
    public function actionCreate()
    {
        $manager = new SettingsManager();
        foreach ($this->getSettings() as $key => $item) {
            $manager->save($key, $item['value'], $item['type_id']);
        }
    }

    protected function getSettings()
    {
        return  [
            'app_meta_title' => [
                'value' => 'Site name',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],
            'app_meta_keywords' => [
                'value' => 'keyword1,keyword2,keyword3',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],
            'app_meta_description' => [
                'value' => 'site meta description',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],
            'app_index_url' => [
                'value' => 'site/index',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],
            'app_theme' => [
                'value' => 'base',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],
            'app_payments_CodPayments_on' => [
                'value' => SettingOption::BOOL_VAL_TRUE,
                'type_id' => SettingOption::TYPE_ID_BOOL,
            ],

            'app_Eautopay_userapikey' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_Eautopay_customerapikey' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_Eautopay_apiurl' => [
                'value' => 'https://api.e-autopay.com/v01/',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_payments_CashPayments_on' => [
                'value' => SettingOption::BOOL_VAL_TRUE,
                'type_id' => SettingOption::TYPE_ID_BOOL,
            ],

            'app_payments_RbkMoneyPayments_on' => [
                'value' => SettingOption::BOOL_VAL_TRUE,
                'type_id' => SettingOption::TYPE_ID_BOOL,
            ],

            'app_payments_RbkMoneyPayments_id' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_payments_RbkMoneyPayments_key' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_payments_RobokassaPayments_on' => [
                'value' => SettingOption::BOOL_VAL_TRUE,
                'type_id' => SettingOption::TYPE_ID_BOOL,
            ],

            'app_payments_RobokassaPayments_login' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_payments_RobokassaPayments_pass1' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_payments_RobokassaPayments_pass2' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_payments_ZPaymentPayments_on' => [
                'value' => SettingOption::BOOL_VAL_TRUE,
                'type_id' => SettingOption::TYPE_ID_BOOL,
            ],

            'app_payments_ZPaymentPayments_id' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_payments_ZPaymentPayments_key' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_payments_InterkassaPayments_on' => [
                'value' => SettingOption::BOOL_VAL_TRUE,
                'type_id' => SettingOption::TYPE_ID_BOOL,
            ],

            'app_payments_InterkassaPayments_id' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_payments_InterkassaPayments_key' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_payments_PaypalPayments_on' => [
                'value' => SettingOption::BOOL_VAL_TRUE,
                'type_id' => SettingOption::TYPE_ID_BOOL,
            ],

            'app_payments_PaypalPayments_login' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_payments_YandexPayments_on' => [
                'value' => SettingOption::BOOL_VAL_TRUE,
                'type_id' => SettingOption::TYPE_ID_BOOL,
            ],

            'app_payments_YandexPayments_shopId' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_payments_YandexPayments_scid' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],

            'app_payments_YandexPayments_shopPass' => [
                'value' => '123',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],
        ];
    }
}
