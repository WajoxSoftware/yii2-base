<?php
namespace wajox\yii2base\models;

class Good extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;
    use \wajox\yii2base\traits\UpdatedAtTrait;

    const VIEW_ROUTE = '/shop/goods/view';

    const TYPE_ID_ELECTRONIC = 101;
    const TYPE_ID_PHYSICAL = 102;

    const STATUS_ID_ACTIVE = 100;
    const STATUS_ID_INACTIVE = 102;
    const STATUS_ID_ARCHIVE = 103;
    const STATUS_ID_DRAFT = 104;

    const PARTNER_STATUS_ID_ACTIVE = 100;
    const PARTNER_STATUS_ID_INACTIVE = 101;

    public static function tableName()
    {
        return 'good';
    }

    public function behaviors()
    {
        return [
            'serializedAttributes' => [
                'class' => "\baibaratsky\yii\behaviors\model\SerializedAttributes",
                'attributes' => ['content'],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['title', 'url'], 'filter', 'filter' => 'strip_tags'],
            [['title', 'url'], 'filter', 'filter' => 'htmlentities'],
            [['title', 'url'], 'filter', 'filter' => 'trim'],
            [['user_id', 'title', 'sum', 'status_id', 'created_at'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'status_id'], 'integer'],
            [['sum'], 'double', 'min' => 0],
            [['url', 'title'], 'string', 'max' => 255],
            ['url', 'unique'],
            [['tags'], 'filter', 'filter' => 'strip_tags'],
            [['tags'], 'filter', 'filter' => 'trim'],
            [['description'], 'string'],
            [['tags'], 'string', 'max' => 255],
            [['description'], 'string'],
            ['status_id', 'in', 'range' => array_keys($this::getStatusIdList())],
            ['partner_status_id', 'in', 'range' => array_keys($this::getPartnerStatusIdList())],
            ['good_type_id', 'in', 'range' => array_keys($this::getTypeIdList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'url' => \Yii::t('app/attributes', 'Url'),
            'category_id' => \Yii::t('app/attributes', 'Category ID'),
            'parent_good_default' => \Yii::t('app/attributes', 'Parent Good Default'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'sum' => \Yii::t('app/attributes', 'Price'),
            'status' => \Yii::t('app/attributes', 'Status'),
            'deliveryPrice' => \Yii::t('app/attributes', 'Good Delivery Price'),
            'title' => \Yii::t('app/attributes', 'Title'),
            'short_description' => \Yii::t('app/attributes', 'Short Description'),
            'description' => \Yii::t('app/attributes', 'Description'),
            'tags' => \Yii::t('app/attributes', 'Tags'),
            'partner_status_id' => \Yii::t('app/attributes', 'Good Partner Program Status'),
            'partnerProgramStatus' => \Yii::t('app/attributes', 'Good Partner Program Status'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
            'updated_at' => \Yii::t('app/attributes', 'Updated At'),
            'valid_until' => \Yii::t('app/attributes', 'Good Valid Until'),
            'createdDate' => \Yii::t('app/attributes', 'Created At'),
            'payment_methods' => \Yii::t('app/attributes', 'Good Payment Methods'),
            'delivery_methods' => \Yii::t('app/attributes', 'Good Delivery Methods'),
        ];
    }

    public static function getStatusIdList()
    {
        return [
            self::STATUS_ID_DRAFT => \Yii::t('app/attributes', 'Good Status Draft'),
            self::STATUS_ID_ARCHIVE => \Yii::t('app/attributes', 'Good Status Archive'),
            self::STATUS_ID_INACTIVE => \Yii::t('app/attributes', 'Good Status Inactive'),
            self::STATUS_ID_ACTIVE => \Yii::t('app/attributes', 'Good Status Active'),
        ];
    }

    public static function getPartnerStatusIdList()
    {
        return [
            self::PARTNER_STATUS_ID_INACTIVE => \Yii::t('app/attributes', 'Good Partner Program Status Inactive'),
            self::PARTNER_STATUS_ID_ACTIVE => \Yii::t('app/attributes', 'Good Partner Program Status Active'),
        ];
    }

    public static function getTypeIdList()
    {
        return [
            self::TYPE_ID_PHYSICAL => \Yii::t('app/attributes', 'Good Type Physical'),
            self::TYPE_ID_ELECTRONIC => \Yii::t('app/attributes', 'Good Type Electronic'),
        ];
    }

    public function getGoodType()
    {
        return self::getTypeIdList()[$this->good_type_id];
    }

    public function getStatus()
    {
        $sl = self::getStatusIdList();

        return $sl[$this->status_id];
    }

    public function getOrderUrl()
    {
        return [self::VIEW_ROUTE, 'url' => $this->url];
    }

    public function getIsElectronic()
    {
        return $this->good_type_id == self::TYPE_ID_ELECTRONIC;
    }

    public function getIsPhysical()
    {
        return $this->good_type_id == self::TYPE_ID_PHYSICAL;
    }

    public function getAuthorName()
    {
        if (!$this->author) {
            return \Yii::t('app/attributes', 'Unknown');
        }

        return $this->author->nameWithEmail;
    }

    public function getSumRUR()
    {
        return $this->sum;
    }

    public function getPartnerProgramStatus()
    {
        $sl = self::getPartnerProgramStatusIdList();

        return $sl[$this->partner_status_id];
    }

    public function getIsPartnerProgramActive()
    {
        return $this->partner_status_id == self::PARTNER_STATUS_ID_ACTIVE;
    }

    public function getIsActive()
    {
        return $this->status_id == self::STATUS_ID_ACTIVE;
    }

    public function getIsInactive()
    {
        return $this->status_id == self::STATUS_ID_INACTIVE;
    }

    public function getIsArchive()
    {
        return $this->status_id == self::STATUS_ID_ARCHIVE;
    }

    public function getIsDraft()
    {
        return $this->status_id == self::STATUS_ID_DRAFT;
    }

    public function getPartnerPrograms()
    {
        return $this->hasMany(GoodPartnerProgram::className(), ['good_id' => 'id']);
    }

    public function getPartnerProgram()
    {
        return $this->hasOne(GoodPartnerProgram::className(), ['good_id' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(GoodCategory::className(), ['id' => 'category_id']);
    }

    public function getLetters()
    {
        return $this->hasMany(GoodLetter::className(), ['good_id' => 'id']);
    }

    public function getImages()
    {
        return $this->hasMany(GoodImage::className(), ['good_id' => 'id']);
    }

    public function getEntities()
    {
        return $this->hasMany(EGoodEntity::className(), ['good_id' => 'id']);
    }

    public function getDeliveryMethods()
    {
        return $this->hasMany(GoodDeliveryMethod::className(), ['good_id' => 'id']);
    }

    public function getPaymentMethods()
    {
        return $this->hasMany(GoodPaymentMethod::className(), ['good_id' => 'id']);
    }

    public function getCoupons()
    {
        return $this->hasMany(GoodUserCoupon::className(), ['good_id' => 'id']);
    }

    public function getEmailLists()
    {
        return $this->hasMany(EmailList::className(), ['id' => 'email_list_id'])
        ->viaTable(GoodEmailList::tableName(), ['good_id' => 'id']);
    }

    public function getGoodEmailLists()
    {
        return $this->hasMany(GoodEmailList::className(), ['good_id' => 'id']);
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getParentGood()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_good_id']);
    }

    public function getGoods()
    {
        return $this->hasMany(self::className(), ['parent_good_id' => 'id']);
    }

    public function getHasParent()
    {
        return $this->parent_good_id != 0;
    }

    public function getContentParam($name)
    {
        if (isset($this->content[$name])) {
            return $this->content[$name];
        }

        return;
    }

    public function setContentParam($name, $value)
    {
        $this->content[$name] = $value;

        return $this;
    }
}
