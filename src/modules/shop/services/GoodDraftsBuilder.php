<?php
/**
 * @FIXME: DEPRECATED
 */
namespace wajox\yii2base\modules\shop\services;

use wajox\yii2base\modules\shop\models\Good;

class GoodDraftsBuilder extends \wajox\yii2base\components\base\Object
{
    public $user = null;
    public $source = null;
    public $good = null;
    public $cloneMode = false;

    public function __construct($user, $source = null, $cloneMode = false)
    {
        $this
            ->setUser($user)
            ->setSource($source)
            ->setCloneMode($cloneMode);
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

    public function setSource($source = null)
    {
        $this->source = $source;

        return $this;
    }

    public function getSource()
    {
        return $this->source;
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

    public function setCloneMode($cloneMode)
    {
        $this->cloneMode = $cloneMode;

        return $this;
    }

    public function getCloneMode()
    {
        return $this->cloneMode;
    }

    public function enableCloneMode()
    {
        return $this->setCloneMode(true);
    }

    public function disableCloneMode()
    {
        return $this->setCloneMode(false);
    }

    public function isCloneModeEnabled()
    {
        return $this->getCloneMode() == true;
    }

    public function create()
    {
        try {
            if ($this->isSourceExists()) {
                return $this->createFromSource();
            }

            return $this->createEmpty();
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function createEmpty()
    {
        $good = $this->createObject(Good::className());
        $good->status_id = Good::STATUS_ID_DRAFT;
        $good->title = 'New Good';
        $good->sum = 1;

        $builder = $this->getBuilder($good);

        if (!$builder->save()) {
            throw new \Exception('Can not create empty draft');
        }

        $this->setGood($builder->getGood());

        return true;
    }

    protected function createFromSource()
    {
        if (!$this->isSourceExists()) {
            throw new \Exception('Source good does not specified');
        }

        $good = clone $this->getSource();
        $good->id = null;
        $good->isNewRecord = true;
        $good->status_id = Good::STATUS_ID_DRAFT;

        $builder = $this->getBuilder($good)->setCategory($this->getSource()->category);

        if (!$builder->save()) {
            throw new \Exception('Can not clone this good');
        }

        $good = $builder->getGood();

        $this->setGood($good);

        $this->cloneSourceRelations($good);

        return true;
    }

    protected function cloneSourceRelations($good)
    {
        if (!$this->isSourceExists()) {
            throw new \Exception('Source good does not specified');
        }

        if ($this->getSource()->isNewRecord && !$this->isCloneModeEnabled()) {
            return true;
        }

        $relations = [
            //'partnerPrograms',
            'letters',
            'coupons',
            'goodEmailLists',
        ];

        foreach ($relations as $relation) {
            $this->cloneSourceRelation($good, $relation);
        }

        return true;
    }

    protected function cloneSourceRelation($good, $relation)
    {
        foreach ($this->source->$relation as $item) {
            $goodRelation = clone $item;
            $goodRelation->id = 0;
            $goodRelation->good_id = $good->id;
            if (!$goodRelation->save()) {
                throw new \Exception('Error while cloning relations');
            }
        }
    }

    protected function isSourceExists()
    {
        return $this->getSource() !== null;
    }

    protected function getBuilder($model = null)
    {
        $model = $model ?: $this->createObject(Good::className());

        $manager = $this->createObject(
            GoodsManager::className(),
            [$this->user, $model]
        );

        return $manager->getBuilder($model->good_type_id)->build();
    }
}
