<?php
namespace wajox\yii2base\services\mail;

use wajox\yii2base\services\base\BaseAdapterManager;

class Sender extends BaseAdapterManager
{
    public function __construct()
    {
        $adapterClass = $this->getApp()->settings->get('app_mail_adapter_class');
        parse_str($this->getApp()->settings->get('app_mail_adapter_params'), $adapterParams);
        $adapterParams['from'] =  $this->getApp()->settings->get('app_mail_adapter_from');

        $this->createAdapter($adapterClass, $adapterParams);
    }
}
