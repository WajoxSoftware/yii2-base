<?php
namespace wajox\yii2base\modules\shop\services\goods\builders;

use wajox\yii2base\modules\shop\models\Good;
use wajox\yii2base\modules\shop\models\GoodLetter;
use wajox\yii2base\modules\shop\models\GoodPartnerProgram;
use wajox\yii2base\helpers\TextHelper;
use wajox\yii2base\modules\payment\services\delivery\DeliveryMethodsManager;
use wajox\yii2base\components\base\Object;

abstract class GoodsBuilderAbstract extends Object
{
    protected $user = null;
    protected $good = null;
    protected $goodPartner = null;
    protected $category = null;
    protected $request = null;
    protected $errors = [];
    protected $form = null;

    protected $isAutomatedDeliveryBuildEnabled = true;
    protected $isAutomatedPaymentBuildEnabled = false;

    abstract public function createForm();

    public function __construct($user, $good = null)
    {
        $this->setUser($user)
             ->setGood($good)
             ->buildForm();
    }

    public function buildForm()
    {
        $this->createForm();
        $this->form->setModel($this->good);

        return $this;
    }

    public function getForm()
    {
        return $this->form;
    }

    protected function setForm($form)
    {
        $this->form = $form;

        return $this;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function load($request = null)
    {
        if ($request === null) {
            return $this;
        }

        $this->request = $request;
        $this->form->load($request->post());

        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setGood($good)
    {
        $this->good = $good;

        return $this;
    }

    public function getGood()
    {
        return $this->good;
    }

    public function build()
    {
        return $this->buildForm();
    }

    public function save($request = null)
    {
        $ta = $this->getApp()->db->beginTransaction();

        try {
            $this->buildForm()
                 ->load($request)
                 ->validateForm()
                 ->buildModels()
                 ->saveModels();
        } catch (\Exception $e) {
            $ta->rollBack();
            
            return false;
        }

        $ta->commit();

        return true;
    }

    public function createDraft($sourceModel = null)
    {
        if ($sourceModel == null) {
            $this->createEmptyDraft();

            return $this;
        }

        $this->createDraftFromSource($sourceModel);

        return $this;
    }

    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    protected function validateForm()
    {
        if (!$this->form->validate()) {
            throw new \Exception('Invalid data');
        }

        return $this;
    }

    protected function buildModels()
    {
        return $this->buildGood()
                    ->buildGoodPartner();
    }

    protected function saveModels()
    {
        $conn = $this->good->getDb();
        $transaction = $conn->beginTransaction();
        try {
            $this->saveGood()
                 ->saveGoodPartner()
                 ->savePayments()
                 ->saveDelivery()
                 ->saveRelations();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    protected function buildGood()
    {
        if ($this->getGood() == null) {
            $this->good = $this->createObject(Good::className());
        }

        $this->good->setAttributes($this->getForm()->getModelData());
        $this->setDefaultData();

        return $this;
    }

    protected function buildGoodPartner()
    {
        if ($this->getGood() == null
            || $this->getGood()->partnerProgram == null
        ) {
            $this->goodPartner = $this->createObject(GoodPartnerProgram::className());
        } else {
            $this->goodPartner = $this->getGood()->partnerProgram;
        }

        $this->goodPartner->setAttributes($this->getForm()->getModelPartnerData());

        return $this;
    }

    protected function saveGood()
    {
        if (!$this->good->save()) {
            $message = implode(', '.$this->good->errors);
            throw new \Exception($message);
        }

        return $this;
    }

    protected function saveGoodPartner()
    {
        if (!$this->good->isPartnerProgramActive) {
            return $this;
        }

        $this->goodPartner->good_id = $this->getGood()->id;

        if (!$this->goodPartner->save()) {
            $message = implode(', '.$this->goodPartner->errors);
            throw new \Exception($message);
        }

        return $this;
    }

    protected function savePayments()
    {
        if (!$this->isAutomatedPaymentBuildEnabled) {
            return $this;
        }

        throw new \Exception('Unable to save payment methods');

        return $this;
    }

    protected function saveDelivery()
    {
        if (!$this->isAutomatedDeliveryBuildEnabled) {
            return $this;
        }

        $manager = $this->createObject(
            DeliveryMethodsManager::className(),
            [$this->getGood()]
        );

        $success = $manager
            ->detachMethods()
            ->attachMethods($this->getActualDeliveryMethods());

        if (!$success) {
            throw new \Exception('Unable to save delivery methods');
        }

        return $this;
    }

    protected function saveRelations()
    {
        $lettersQuery = $this
            ->getRepository()
            ->find(GoodLetter::className())
            ->where(['good_id' => 0]);

        foreach ($lettersQuery->each() as $letter) {
            $goodLetter = clone $letter;
            $goodLetter->id = 0;
            $goodLetter->isNewRecord = true;
            $goodLetter->good_id = $this->getGood()->id;
            $goodLetter->save();
        }
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
        return $this->getGood()->isNewRecord;
    }

    protected function setDefaultData()
    {
        $this->generateGoodUrl();
        $this->good->user_id = $this->getUser()->id;

        if ($this->isNew() && empty($this->getGood()->status_id)) {
            $this->good->status_id = Good::STATUS_ID_ACTIVE;
        } elseif (!$this->isNew() && $this->getGood()->isDraft) {
            $this->good->status_id = Good::STATUS_ID_ACTIVE;
        }

        if ($this->isNew()) {
            $this->good->good_type_id = $this->getGoodTypeId();
            $this->good->created_at = time();
            $this->good->category_id = $this->getCategory()->id;
        }

        $this->good->updated_at = time();
    }

    protected function generateGoodUrl()
    {
        $url = TextHelper::str2url($this->getGood()->url);

        if (empty($url)) {
            $url = TextHelper::str2url($this->getGood()->title);
        }

        if (empty($url)) {
            return;
        }

        if (!$this->isUrlExists($url)) {
            $this->good->url = $url;

            return;
        }

        $uniqId = $this->isNew() ? uniqid() : $this->getGood()->id;
        $url = TextHelper::str2url($url, $uniqId);

        if (!$this->isUrlExists($url)) {
            $this->good->url = $url;

            return;
        }
    }

    protected function isUrlExists($url)
    {
        $query = $this
            ->getRepository()
            ->find(Good::className())
            ->where(['url' => $url]);

        if (!$this->isNew()) {
            $query = $query->andWhere(
                ['!=', 'id', $this->getGood()->id]
            );
        }

        return $query->exists();
    }

    protected function getActualDeliveryMethods()
    {
        $params = [
            'price' => $this->getForm()->deliveryPrice,
            'extra' => ['delivery_good_id' => $this->getForm()->deliveryId],
        ];

        if ($this->getGood()->isPhysical
            && $this->getForm()->isCashOnDelivery
        ) {
            return ['CodDelivery' => $params];
        }

        if ($this->getGood()->isElectronic) {
            return ['EmailDelivery' => $params];
        }

        return ['SystemDelivery' => $params];
    }

    abstract protected function getGoodTypeId();
}
