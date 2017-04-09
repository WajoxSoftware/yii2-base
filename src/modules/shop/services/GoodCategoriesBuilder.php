<?php
namespace wajox\yii2base\modules\shop\services;

use wajox\yii2base\modules\shop\models\GoodCategory;
use wajox\yii2base\helpers\TextHelper;
use wajox\yii2base\components\base\Object;

class GoodCategoriesBuilder extends Object
{
    protected $goodCategory = null;
    protected $parentCategoryId = null;
    protected $request = null;

    public function __construct($goodCategory = null)
    {
        $this->setGoodCategory($goodCategory);
    }

    public function setParentCategoryId($parentCategoryId)
    {
        if ($parentCategoryId <= 0
            || !$parentCategoryId
        ) {
            $parentCategoryId = null;
        }

        $this->parentCategoryId =$parentCategoryId;

        return $this;
    }

    public function getParentCategoryId()
    {
        return $this->parentCategoryId;
    }

    public function load($request = null)
    {
        if ($request === null) {
            return $this;
        }

        $this->request = $request;
        $this->goodCategory->load($request->post());

        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function setGoodCategory($goodCategory)
    {
        $this->goodCategory = $goodCategory;

        return $this;
    }

    public function getGoodCategory()
    {
        return $this->goodCategory;
    }

    public function validate()
    {
        if (!$this->getGoodCategory()->validate()) {
            throw new \Exception('Invalid category data');
        }

        return $this;
    }

    public function save($request = null)
    {
        try {
            $this->load($request)
                 ->buildGoodCategory()
                 ->validate()
                 ->saveGoodCategory();
        } catch (\Exception $e) {
            return false;
        }
        
        return true;
    }

    public function buildGoodCategory()
    {
        if ($this->getGoodCategory() == null) {
            $this->goodCategory = new GoodCategory();
        }

        $this->setDefaultData();

        return $this;
    }

    protected function saveGoodCategory()
    {
        if (!$this->goodCategory->save()) {
            $message = implode(', '.$this->goodCategory->errors);
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
        return $this->getGoodCategory()->isNewRecord;
    }

    protected function setDefaultData()
    {
        $this->generateGoodCategoryUrl();

        if ($this->isNew() && empty($this->getGoodCategory()->status_id)) {
            $this->goodCategory->status_id = GoodCategory::STATUS_ID_ACTIVE;
        }

        if ($this->isNew()) {
            $this->goodCategory->parent_id = $this->getParentCategoryId();
            $this->goodCategory->parents_ids = $this->getParentCategoryIds();
        }
    }

    protected function getParentCategoryIds()
    {
        if ($this->getParentCategoryId() == null) {
            return '0';
        }

        $parentCategory = $this
            ->getRepository()
            ->find(GoodCategory::className())
            ->byId($this->getParentCategoryId())
            ->one();

        if (!$parentCategory) {
            return '0';
        }

        return $parentCategory->parents_ids . ',' . $parentCategory->id;
    }

    protected function generateGoodCategoryUrl()
    {
        $url = TextHelper::str2url($this->getGoodCategory()->url);

        if (empty($url)) {
            $url = TextHelper::str2url($this->getGoodCategory()->title);
        }

        if (empty($url)) {
            return;
        }

        if (!$this->isUrlExists($url)) {
            $this->goodCategory->url = $url;

            return;
        }

        $uniqId = $this->isNew() ? uniqid() : $this->getGoodCategory()->id;
        $url = TextHelper::str2url($url, $uniqId);

        if (!$this->isUrlExists($url)) {
            $this->goodCategory->url = $url;

            return;
        }
    }

    protected function isUrlExists($url)
    {
        $query = $this
            ->getRepository()
            ->find(GoodCategory::className())
            ->byUrl($url);

        if (!$this->isNew()) {
            $query = $query->andWhere(
                ['!=', 'id', $this->getGoodCategory()->id]
            );
        }

        return $query->exists();
    }
}
