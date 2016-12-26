<?php
namespace wajox\yii2base\modules\admin\models;

use yii\base\Model;

class SettingsForm extends \wajox\yii2base\components\base\Model
{
    public $app_meta_title;
    public $app_meta_keywords;
    public $app_index_url;
    public $app_theme;
    public $app_meta_description;
    public $app_payments_CodPayments_on;
    public $app_Eautopay_userapikey;
    public $app_Eautopay_customerapikey;
    public $app_Eautopay_apiurl;
    public $app_payments_CashPayments_on;
    public $app_payments_RbkMoneyPayments_on;
    public $app_payments_RbkMoneyPayments_id;
    public $app_payments_RbkMoneyPayments_key;
    public $app_payments_RobokassaPayments_on;
    public $app_payments_RobokassaPayments_login;
    public $app_payments_RobokassaPayments_pass1;
    public $app_payments_RobokassaPayments_pass2;
    public $app_payments_ZPaymentPayments_on;
    public $app_payments_ZPaymentPayments_id;
    public $app_payments_ZPaymentPayments_key;
    public $app_payments_InterkassaPayments_on;
    public $app_payments_InterkassaPayments_id;
    public $app_payments_InterkassaPayments_key;
    public $app_payments_PaypalPayments_on;
    public $app_payments_PaypalPayments_login;
    public $app_payments_YandexPayments_on;
    public $app_payments_YandexPayments_shopId;
    public $app_payments_YandexPayments_scid;
    public $app_payments_YandexPayments_shopPass;
    public $app_mail_adapter_class;
    public $app_mail_adapter_from;
    public $app_mail_adapter_params;

    public function rules()
    {
        return [
            [['app_meta_title', 'app_meta_keywords',
            'app_index_url', 'app_theme',
            'app_meta_description', 'app_payments_RbkMoneyPayments_id', 'app_payments_RbkMoneyPayments_key',
            'app_payments_RobokassaPayments_login', 'app_payments_RobokassaPayments_pass1',
            'app_payments_RobokassaPayments_pass2', 'app_payments_ZPaymentPayments_id',
            'app_payments_ZPaymentPayments_key', 'app_payments_InterkassaPayments_id',
            'app_payments_InterkassaPayments_key', 'app_payments_PaypalPayments_login',
            'app_payments_YandexPayments_scid', 'app_payments_YandexPayments_shopPass',
            'app_Eautopay_userapikey', 'app_Eautopay_customerapikey', 'app_Eautopay_apiurl',
            'app_mail_adapter_class', 'app_mail_adapter_params', 'app_mail_adapter_from', ], 'filter', 'filter' => 'strip_tags'],

            [['app_meta_title', 'app_meta_keywords',
            'app_index_url', 'app_theme',
            'app_meta_description', 'app_payments_RbkMoneyPayments_id', 'app_payments_RbkMoneyPayments_key',
            'app_payments_RobokassaPayments_login', 'app_payments_RobokassaPayments_pass1',
            'app_payments_RobokassaPayments_pass2', 'app_payments_ZPaymentPayments_id',
            'app_payments_ZPaymentPayments_key', 'app_payments_InterkassaPayments_id',
            'app_payments_InterkassaPayments_key', 'app_payments_PaypalPayments_login',
            'app_payments_YandexPayments_shopId',
            'app_payments_YandexPayments_scid', 'app_payments_YandexPayments_shopPass',
            'app_Eautopay_userapikey', 'app_Eautopay_customerapikey', 'app_Eautopay_apiurl',
            'app_mail_adapter_class', 'app_mail_adapter_params', 'app_mail_adapter_from', ], 'filter', 'filter' => 'trim'],
            // rememberMe must be a boolean value
            [['app_payments_CodPayments_on', 'app_payments_CashPayments_on', 'app_payments_RbkMoneyPayments_on',
            'app_payments_RobokassaPayments_on', 'app_payments_ZPaymentPayments_on', 'app_payments_InterkassaPayments_on',
            'app_payments_PaypalPayments_on', 'app_payments_YandexPayments_on', ], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'app_meta_title' => \Yii::t('app/admin', 'Settings app_meta_title'),
            'app_meta_keywords' => \Yii::t('app/admin', 'Settings app_meta_keywords'),
            'app_meta_description' => \Yii::t('app/admin', 'Settings app_meta_description'),
            'app_index_url' => \Yii::t('app/admin', 'Settings app_index_url'),
            'app_theme' => \Yii::t('app/admin', 'Settings app_theme'),
            'app_payments_CodPayments_on' => \Yii::t('app/admin', 'Settings app_payments_CodPayments_on'),
            'app_Eautopay_userapikey'  => \Yii::t('app/admin', 'Settings app_Eautopay_userapikey'),
            'app_Eautopay_customerapikey' => \Yii::t('app/admin', 'Settings app_Eautopay_customerapikey'),
            'app_Eautopay_apiurl' => \Yii::t('app/admin', 'Settings app_Eautopay_apiurl'),
            'app_payments_CashPayments_on' => \Yii::t('app/admin', 'Settings app_payments_CashPayments_on'),
            'app_payments_RbkMoneyPayments_on' => \Yii::t('app/admin', 'Settings app_payments_RbkMoneyPayments_on'),
            'app_payments_RbkMoneyPayments_id' => \Yii::t('app/admin', 'Settings app_payments_RbkMoneyPayments_id'),
            'app_payments_RbkMoneyPayments_key' => \Yii::t('app/admin', 'Settings app_payments_RbkMoneyPayments_key'),
            'app_payments_RobokassaPayments_on' => \Yii::t('app/admin', 'Settings app_payments_RobokassaPayments_on'),
            'app_payments_RobokassaPayments_login' => \Yii::t('app/admin', 'Settings app_payments_RobokassaPayments_login'),
            'app_payments_RobokassaPayments_pass1' => \Yii::t('app/admin', 'Settings app_payments_RobokassaPayments_pass1'),
            'app_payments_RobokassaPayments_pass2' => \Yii::t('app/admin', 'Settings app_payments_RobokassaPayments_pass2'),
            'app_payments_ZPaymentPayments_on' => \Yii::t('app/admin', 'Settings app_payments_ZPaymentPayments_on'),
            'app_payments_ZPaymentPayments_id' => \Yii::t('app/admin', 'Settings app_payments_ZPaymentPayments_id'),
            'app_payments_ZPaymentPayments_key' => \Yii::t('app/admin', 'Settings app_payments_ZPaymentPayments_key'),
            'app_payments_InterkassaPayments_on' => \Yii::t('app/admin', 'Settings app_payments_InterkassaPayments_on'),
            'app_payments_InterkassaPayments_id' => \Yii::t('app/admin', 'Settings app_payments_InterkassaPayments_id'),
            'app_payments_InterkassaPayments_key' => \Yii::t('app/admin', 'Settings app_payments_InterkassaPayments_key'),
            'app_payments_PaypalPayments_on' => \Yii::t('app/admin', 'Settings app_payments_PaypalPayments_on'),
            'app_payments_PaypalPayments_login' => \Yii::t('app/admin', 'Settings app_payments_PaypalPayments_login'),
            'app_payments_YandexPayments_on' => \Yii::t('app/admin', 'Settings app_payments_YandexPayments_on'),
            'app_payments_YandexPayments_shopId' => \Yii::t('app/admin', 'Settings app_payments_YandexPayments_shopId'),
            'app_payments_YandexPayments_scid' => \Yii::t('app/admin', 'Settings app_payments_YandexPayments_scid'),
            'app_payments_YandexPayments_shopPass' => \Yii::t('app/admin', 'Settings app_payments_YandexPayments_shopPass'),
            'app_mail_adapter_class' => \Yii::t('app/admin', 'Settings app_mail_adapter_class'),
            'app_mail_adapter_from' => \Yii::t('app/admin', 'Settings app_mail_adapter_from'),
            'app_mail_adapter_params' => \Yii::t('app/admin', 'Settings app_mail_adapter_params'),
        ];
    }

    public function loadSettings()
    {
        foreach ($this->getApp()->settings->load()->all() as $key => $item) {
            $this->$key = $item->value;
        }
    }

    public function updateSettings()
    {
        foreach ($this->getApp()->settings->load()->all() as $key => $item) {
            $item->setValue($this->$key);
            $item->save();
        }

        $this->loadSettings();
    }
}
