<?php
namespace wajox\yii2base\models;

class ContentNode extends \wajox\yii2base\components\db\ActiveRecord
{
    use \wajox\yii2base\traits\CreatedAtTrait;

    const DEFAULT_PREVIEW_PATH = '@noImagePath';
    const DEFAULT_FILE_PATH = '@noImagePath';

    const VIEW_ROUTE = '/content/default/view';

    const TYPE_ID_CATALOG = 101;
    const TYPE_ID_PAGE = 201;

    const STATUS_ID_NEW = 100;
    const STATUS_ID_PUBLISHED = 200;
    const STATUS_ID_ARCHIVE = 300;

    const LAYOUT_EMPTY = 'empty';
    const LAYOUT_MAIN = '//main';
    const LAYOUT_NARROW = '//narrow';

    public static function tableName()
    {
        return 'content_node';
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
            [['title', 'url', 'content', 'parent_node_id', 'type_id', 'user_id', 'layout', 'created_at'], 'required'],
            [['title', 'url', 'tags', 'layout'], 'filter', 'filter' => 'strip_tags'],
            [['title', 'url', 'tags', 'layout'], 'filter', 'filter' => 'htmlentities'],
            [['title', 'url', 'tags', 'layout'], 'filter', 'filter' => 'trim'],
            [['parent_node_id', 'type_id', 'preview_image_id'], 'integer'],
            [['url', 'title', 'layout', 'tags'], 'string', 'max' => 255],
            ['url', 'unique'],
            ['layout', 'in', 'range' => array_keys($this::getLayoutsList())],
            ['status_id', 'in', 'range' => array_keys($this::getStatusIdList())],
            ['type_id', 'in', 'range' => array_keys($this::getTypeIdList())],
        ];
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_node_id']);
    }

    public function getHasParent()
    {
        return $this->parent_node_id != 0;
    }

    public function getParents()
    {
        if ($this->parent_node_id == 0
            || $this->parent_node_ids == ''
        ) {
            return [];
        }

        $ids = explode(',', $this->parent_node_ids);

        return ContentNode::find()->where([
                'id' => $ids,
            ])->orderBy('id ASC')->all();
    }

    public function getContentNodes()
    {
        return $this->hasMany(self::className(), ['parent_node_id' => 'id']);
    }

    public static function getLayoutsList()
    {
        return [
            self::LAYOUT_EMPTY => \Yii::t('app/attributes', 'Content Node Empty Layout'),
            self::LAYOUT_MAIN => \Yii::t('app/attributes', 'Content Node Main Layout'),
            self::LAYOUT_NARROW => \Yii::t('app/attributes', 'Content Node Narrow Layout'),
        ];
    }

    public static function getStatusIdList()
    {
        return [
            self::STATUS_ID_NEW => \Yii::t('app/attributes', 'Content Node Status New'),
            self::STATUS_ID_PUBLISHED => \Yii::t('app/attributes', 'Content Node Status Published'),
            self::STATUS_ID_ARCHIVE => \Yii::t('app/attributes', 'Content Node Status Archive'),
        ];
    }

    public static function getTypeIdList()
    {
        return [
            self::TYPE_ID_CATALOG => \Yii::t('app/attributes', 'Content Node Type Catalog'),
            self::TYPE_ID_PAGE => \Yii::t('app/attributes', 'Content Node Type Page'),
        ];
    }

    public function getType()
    {
        return $this->getTypeIdList()[$this->type_id];
    }

    public function getPreviewImageThumbUrl()
    {
        $file = $this->previewImage ? $this->previewImage->previewUrl : \Yii::getAlias(self::DEFAULT_PREVIEW_PATH);

        return $file;
    }

    public function getPreviewImage()
    {
        return $this->hasOne(UploadedImage::className(), ['id' => 'preview_image_id']);
    }

    public function getPreviewImageUrl()
    {
        $file = $this->previewImage ? $this->previewImage->fileUrl : \Yii::getAlias(self::DEFAULT_FILE_PATH);

        return $file;
    }

    public function getPageUrl()
    {
        return \yii\helpers\Url::toRoute([self::VIEW_ROUTE, 'url' => $this->url]);
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
