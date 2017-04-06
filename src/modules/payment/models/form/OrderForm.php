<?php
namespace wajox\yii2base\modules\payment\models\form;

use wajox\yii2base\components\base\Model;

class OrderForm extends Model
{
    const SCENARIO_WITH_ADDRESS = 'withAddress';
    const COD_DELIVERY_METHOD = 'CodDelivery';

    public $full_name;
    public $email;
    public $phone;
    public $postalcode;
    public $country;
    public $region;
    public $city;
    public $address;

    protected $goods = [];

    public function rules()
    {
        return [
            [['full_name', 'email', 'phone', 'postalcode', 'country', 'region', 'city', 'address'], 'filter', 'filter' => 'strip_tags'],
            [['full_name', 'email', 'phone', 'postalcode', 'country', 'region', 'city', 'address'], 'filter', 'filter' => 'trim'],
            [['full_name', 'email', 'phone'], 'required'],
            [['postalcode', 'country', 'region', 'city', 'address'], 'required', 'on' => self::SCENARIO_WITH_ADDRESS],
            // email has to be a valid email address
            ['email', 'email'],
            [['phone'], 'match', 'pattern' => '/^[0-9\)\(\+\-)]\w*$/i'],
            [['phone'], 'string', 'max' => 20, 'min' => 2],
            [['postalcode'], 'match', 'pattern' => '/^[0-9]\w*$/i'],
            [['postalcode'], 'string', 'max' => 10, 'min' => 5],
        ];
    }

    public function attributeLabels()
    {
        return [
            'full_name' => \Yii::t('app/attributes', 'Full Name'),
            'email' => \Yii::t('app/attributes', 'Email'),
            'phone' => \Yii::t('app/attributes', 'Phone'),
            'postalcode' => \Yii::t('app/attributes', 'Postal Code'),
            'country' => \Yii::t('app/attributes', 'Country'),
            'region' => \Yii::t('app/attributes', 'Region'),
            'city' => \Yii::t('app/attributes', 'City'),
            'address' => \Yii::t('app/attributes', 'Address'),
        ];
    }

    public function useAddressFields()
    {
        $this->scenario == self::SCENARIO_WITH_ADDRESS;

        return $this;
    }

    public function getIsWithAddress()
    {
        return $this->scenario == self::SCENARIO_WITH_ADDRESS;
    }

    public function getGoods()
    {
        return $this->goods;
    }

    public function setGoods($goods)
    {
        $this->goods = $goods;

        $this->loadParams();

        return $this;
    }

    protected function loadParams()
    {
        foreach ($this->getGoods() as $good) {
            if ($good->isPhysical) {
                $this->useAddressFields();

                return $this;
            }
        }

        return $this;
    }
}
