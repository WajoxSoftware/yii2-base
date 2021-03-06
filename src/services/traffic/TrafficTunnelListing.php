<?php
namespace wajox\yii2base\services\traffic;

use wajox\yii2base\components\base\Component;
use wajox\yii2base\models\User;
use wajox\yii2base\modules\partner\models\Partner;
use wajox\yii2base\models\TrafficManager;
use wajox\yii2base\models\TrafficSource;
use wajox\yii2base\models\TrafficStream;

class TrafficTunnelListing extends Component
{
    const TYPE_ID_INDEX = 100;
    const TYPE_ID_PARTNER_ITEM = 101;
    const TYPE_ID_MANAGER_ITEM = 102;
    const TYPE_ID_SOURCE_ITEM = 103;

    protected $typeId;
    protected $itemId;
    protected $items = null;
    protected $sources = null;
    protected $back = null;

    public function __construct($typeId, $itemId = null)
    {
        $this->setTypeId($typeId)->setItemId($itemId)->load();
    }

    public function getSources()
    {
        return $this->sources;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getBack()
    {
        return $this->back;
    }

    protected function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    protected function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    protected function load()
    {
        if ($this->typeId == self::TYPE_ID_PARTNER_ITEM) {
            return $this->loadPartner();
        }

        if ($this->typeId == self::TYPE_ID_MANAGER_ITEM) {
            return $this->loadManager();
        }

        if ($this->typeId == self::TYPE_ID_SOURCE_ITEM) {
            return $this->loadSource();
        }

        return $this->loadIndex();
    }

    protected function loadIndex()
    {
        $this->items = [
            ['title' => \Yii::t('app/models', 'Partners'), 'urlParams' => ['typeId' => self::TYPE_ID_PARTNER_ITEM]],
            ['title' => \Yii::t('app/models', 'TrafficManagers'), 'urlParams' => ['typeId' => self::TYPE_ID_MANAGER_ITEM]],
        ];

        $this->back = null;
        $this->sources = [
            ['title' => \Yii::t('app/general', 'All')]
        ];
    }

    protected function loadPartner()
    {
        $this->items = null;

        if ($this->itemId == null) {
            $this->back = ['typeId' => self::TYPE_ID_INDEX];
            $this->sources = $this
                ->getRepository()
                ->find(Partner::className());

            return;
        }

        $model = $this
            ->getRepository()
            ->find(User::className())
            ->byId($this->itemId)
            ->one();

        $this->sources =$this
            ->getRepository()
            ->find(TrafficSource::className())
            ->where(['user_id' => $model->id]);
            
        $this->back = ['typeId' => self::TYPE_ID_PARTNER_ITEM, 'itemId' => $model->id];
    }

    protected function loadManager()
    {
        $this->items = null;

        if ($this->itemId == null) {
            $this->back = ['typeId' => self::TYPE_ID_INDEX];
            $this->sources = $this
                ->getRepository()
                ->find(TrafficManager::className());

            return;
        }

        $model = $this
                ->getRepository()
                ->find(User::className())
                ->byId($this->itemId)
                ->one();

        $this->sources = $this
                ->getRepository()
                ->find(TrafficSource::className())
                ->where(['user_id' => $model->id]);

        $this->back = [
            'typeId' => self::TYPE_ID_MANAGER_ITEM,
            'itemId' => $model->id,
        ];
    }

    protected function loadSource()
    {
        $this->items = null;
        $model = $this
                ->getRepository()
                ->find(TrafficSource::className())
                ->byId($this->itemId)
                ->one();

        $this->sources = $this
                ->getRepository()
                ->find(TrafficStream::className())
                ->where([
                    'traffic_source_id' => $model->id,
                ]);

        if ($model->user->isPartner) {
            $this->back = [
                'typeId' => self::TYPE_ID_PARTNER_ITEM,
                'itemId' => $model->user_id,
            ];
        } else {
            $this->back = [
                'typeId' => self::TYPE_ID_MANAGER_ITEM,
                'itemId' => $model->user_id,
            ];
        }
    }
}
