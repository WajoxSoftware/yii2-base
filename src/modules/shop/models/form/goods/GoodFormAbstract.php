<?php
namespace wajox\yii2base\models\form\goods;

use wajox\yii2base\components\base\Model;
use wajox\yii2base\models\Good;
use wajox\yii2base\models\GoodPartnerProgram;
use wajox\yii2base\helpers\GoodsHelper;

class GoodFormAbstract extends Model
{
    public $title;
    public $url;
    public $goodTypeId;

    public $description;
    public $tags;

    public $sum;
    public $deliveryPrice;
    public $isCashOnDelivery;
    public $deliveryId;

    public $partnerStatusId;
    public $partnerPartnerId;
    public $partnerFee1Level;
    public $partnerFee2Level;
    public $partnerLink;

    protected $model = null;
    protected $modelPartner = null;

    public function rules()
    {
        return [
            [['title', 'url', 'tags'], 'filter', 'filter' => 'strip_tags'],
            [['title', 'url', 'tags'], 'filter', 'filter' => 'trim'],
            [['title', 'sum'], 'required'],
            [['partnerStatusId'], 'integer'],
            [['sum', 'deliveryPrice', 'partnerFee1Level', 'partnerFee2Level'], 'double', 'min' => 0],
            [['url', 'title', 'tags', 'deliveryId', 'partnerLink'], 'string', 'max' => 255],
            [['description'], 'string'],
            ['isCashOnDelivery', 'boolean'],
        ];
    }

    public function setModel($model)
    {
        $this->model = $model;

        $this->modelPartner = $this->getModelPartner();

        $this->loadAttributes();
    }

    public function getModel()
    {
        if ($this->model == null) {
            $this->model = $this->createObject(Good::className());
        }

        return $this->model;
    }

    public function getModelPartner()
    {
        if ($this->modelPartner == null) {
            if ($this->model == null || $this->model->partnerProgram == null) {
                $this->modelPartner = $this->createObject(GoodPartnerProgram::className());
            } else {
                $this->modelPartner = $this->model->partnerProgram;
            }
        }

        return $this->modelPartner;
    }

    public function isNew()
    {
        return $this->getModel()->isNewRecord;
    }

    public function getIsNewRecord()
    {
        return $this->getModel()->isNewRecord;
    }

    public function getId()
    {
        return $this->getModel()->id;
    }

    protected function loadAttributes()
    {
        $this->loadModel();
        $this->loadModelContent();
        $this->loadModelPartner();
    }

    protected function loadModel()
    {
        $this->title = $this->getModel()->title;
        $this->url = $this->getModel()->url;
        $this->goodTypeId = $this->getModel()->good_type_id;
        $this->sum = $this->getModel()->sum;
        $this->deliveryPrice = GoodsHelper::getDeliveryPrice($this->getModel());
        $this->isCashOnDelivery = GoodsHelper::isActiveDeliveryMethod($this->getModel(), 'CodDelivery');
        $this->partnerStatusId = $this->getModel()->partner_status_id;
        $this->tags = $this->getModel()->tags;
        $this->description = $this->getModel()->description;

        $this->loadModelContent();
    }

    protected function loadModelPartner()
    {
        $this->partnerPartnerId = $this->getModelPartner()->partner_id;
        $this->partnerFee1Level = $this->getModelPartner()->fee_1_level;
        $this->partnerFee2Level = $this->getModelPartner()->fee_2_level;
        $this->partnerLink = $this->getModelPartner()->partner_link;
    }

    public static function getTypeIdList()
    {
        return Good::getTypeIdList();
    }

    public static function getPartnerStatusIdList()
    {
        return Good::getPartnerStatusIdList();
    }

    public function attributeLabels()
    {
        return [
            'url' => \Yii::t('app/attributes', 'Url'),
            'goodTypeId' => \Yii::t('app/attributes', 'Good Type ID'),
            'isCashOnDelivery' => \Yii::t('app/attributes', 'Cash On Delivery'),
            'sum' => \Yii::t('app/attributes', 'Price'),
            'statusId' => \Yii::t('app/attributes', 'Status'),
            'deliveryPrice' => \Yii::t('app/attributes', 'Delivery Price'),
            'deliveryId' => \Yii::t('app/attributes', 'Good Delivery ID'),
            'title' => \Yii::t('app/attributes', 'Title'),
            'partnerStatusId' => \Yii::t('app/attributes', 'Good Partner Program Status'),
            'validUntil' => \Yii::t('app/attributes', 'Good Valid Until'),
            'createdDate' => \Yii::t('app/attributes', 'Created At'),
            'title' => \Yii::t('app/attributes', 'Title'),
            'description' => \Yii::t('app/attributes', 'Description'),
            'tags' => \Yii::t('app/attributes', 'Tags'),
            'partnerStatusID' => \Yii::t('app/attributes', 'Partner Status ID'),
            'partnerPartnerId' => \Yii::t('app/attributes', 'Partner ID'),
            'partnerFee1Level' => \Yii::t('app/attributes', 'Fee 1 level'),
            'partnerFee2Level' => \Yii::t('app/attributes', 'Fee 2 level'),
            'partnerLink' => \Yii::t('app/attributes', 'Partner Program Link'),
        ];
    }

    public function getModelData()
    {
        return [
            'title' => $this->title,
            'url' => $this->url,
            'good_type_id' => $this->goodTypeId,
            'sum' => $this->sum,
            'partner_status_id' => $this->partnerStatusId ?: Good::PARTNER_STATUS_ID_INACTIVE,
            'tags' => $this->tags,
            'description' => $this->description,
            'content' => $this->getModelContent(),
        ];
    }

    public function getModelPartnerData()
    {
        return [
            'partner_id' => intval($this->partnerPartnerId),
            'fee_1_level' => floatval($this->partnerFee1Level),
            'fee_2_level' => floatval($this->partnerFee2Level),
            'partner_link' => '' . $this->partnerLink,
        ];
    }

    public function loadModelContent()
    {
        return;
    }

    public function getModelContent()
    {
        return [];
    }
}
