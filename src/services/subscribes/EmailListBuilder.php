<?php
namespace wajox\yii2base\services\subscribes;

use wajox\yii2base\models\EmailList;
use wajox\yii2base\helpers\TextHelper;
use wajox\yii2base\components\base\Object;

class EmailListBuilder extends Object
{
    protected $request;
    protected $emailList;

    public function __construct($emailList = null)
    {
        $this->setEmailList($emailList);
    }

    public function load($request = null)
    {
        if ($request === null) {
            return $this;
        }

        $this->request = $request;
        $this->emailList->load($request->post());

        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setEmailList($emailList)
    {
        $this->emailList = $emailList;

        return $this;
    }

    public function getEmailList()
    {
        return $this->emailList;
    }

    public function validate()
    {
        if (!$this->getEmailList()->validate()) {
            throw new \Exception('Invalid email list data');
        }

        return $this;
    }

    public function save($request = null)
    {
        try {
            $this->load($request)
                 ->buildEmailList()
                 ->validate()
                 ->saveEmailList();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function buildEmailList()
    {
        if ($this->getEmailList() == null) {
            $this->emailList = $this->createObject(EmailList::className());
        }

        $this->setDefaultData();

        return $this;
    }

    protected function saveEmailList()
    {
        if (!$this->emailList->save()) {
            $message = implode(', '.$this->emailList->errors);
            throw new \Exception($message);
        }

        return $this;
    }

    protected function clearErrors()
    {
        $this->errors = [];

        return $this;
    }

    protected function addError($message)
    {
        $this->errors[] = $message;

        return $this;
    }

    protected function isNew()
    {
        return $this->getEmailList()->isNewRecord;
    }

    protected function setDefaultData()
    {
        $this->generateEmailListUrl();
    }

    protected function generatEemailListUrl()
    {
        $url = TextHelper::str2url($this->getEmailList()->url);

        if (empty($url)) {
            $url = TextHelper::str2url($this->getEmailList()->title);
        }

        if (empty($url)) {
            return;
        }

        if (!$this->isUrlExists($url)) {
            $this->emailList->url = $url;

            return;
        }

        $uniqId = $this->isNew() ? uniqid() : $this->getEmailList()->id;
        $url = TextHelper::str2url($url, $uniqId);

        if (!$this->isUrlExists($url)) {
            $this->emailList->url = $url;

            return;
        }
    }

    protected function isUrlExists($url)
    {
        $query = $this
            ->getRepository()
            ->find(EmailList::className())
            ->where(['url' => $url]);

        if (!$this->isNew()) {
            $query = $query->andWhere(
                ['!=', 'id', $this->getEmailList()->id]
            );
        }

        return $query->exists();
    }
}
