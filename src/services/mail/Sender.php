<?php
namespace wajox\yii2base\services\mail;

use yii\base\Component;

class Sender extends Component
{
    protected $adapter;

    public function __construct()
    {
        $this->initAdapter();
    }

    public function send($to, $subject, $template, $data = [], $options = [])
    {
        return $this->getAdapter()->send($to, $subject, $template, $data, $options);
    }

    public function addSubscriber($email, $name)
    {
        return $this->getAdapter()->addSubscriber($email, $name);
    }

    public function addUserToList($data)
    {
        return $this->getAdapter()->addUserToList($data);
    }

    public function deleteUserFromList($email, $listId)
    {
        return $this->getAdapter()->deleteUserFromList($email, $listId);
    }

    protected function initAdapter()
    {
        $adapterClass = \Yii::$app->settings->get('app_mail_adapter_class');
        parse_str(\Yii::$app->settings->get('app_mail_adapter_params'), $adapterParams);
        $adapterParams['from'] =  \Yii::$app->settings->get('app_mail_adapter_from');

        $adapter = new $adapterClass($adapterParams);

        $this->setAdapter($adapter);
    }

    protected function setAdapter($adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }
    protected function getAdapter()
    {
        return $this->adapter;
    }
}
