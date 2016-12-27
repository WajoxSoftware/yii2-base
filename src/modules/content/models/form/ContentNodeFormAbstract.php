<?php
namespace wajox\yii2base\modules\content\models\form;

use wajox\yii2base\components\base\Model;
use wajox\yii2base\modules\content\models\ContentNode;

abstract class ContentNodeFormAbstract extends Model
{
    public $title;
    public $url;
    public $layout;
    public $tags;

    protected $preview;

    public function rules()
    {
        return array_merge(
                $this->getBaseRules(),
                $this->getNodeRules()
            );
    }

    public function getBaseRules()
    {
        return [
            [['title'], 'required'],
            [['title', 'url', 'tags'], 'filter', 'filter' => 'strip_tags'],
            [['title', 'url', 'tags'], 'filter', 'filter' => 'trim'],
            [['url', 'title', 'layout'], 'string', 'max' => 255],
            ['layout', 'in', 'range' => array_keys(ContentNode::getLayoutsList())],
        ];
    }

    public function attributeLabels()
    {
        return array_merge($this->getBaseLabels(), $this->getNodeLabels());
    }

    public function getBaseLabels()
    {
        return [
                'id' => \Yii::t('app/attributes', 'ID'),
                'url' => \Yii::t('app/attributes', 'Url'),
                'title' => \Yii::t('app/attributes', 'Title'),
                'layout' => \Yii::t('app/attributes', 'Content Node Layout'),
            ];
    }

    public function getContentNodeAttributes()
    {
        return [
            'title' => $this->title,
            'url' => $this->url,
            'layout' => $this->layout,
            'tags' => $this->tags,
            'type_id' => $this->getTypeId(),
            'content' => $this->getContent(),
        ];
    }

    public function loadContentNodeAttributes($node)
    {
        $this->title = $node->title;
        $this->url = $node->url;
        $this->layout = $node->layout;
        $this->tags = $node->tags;
        $this->preview = $node->previewImage;

        $this->loadContent($node);
    }

    public function getPreviewImage()
    {
        return $this->preview;
    }

    abstract public function getNodeRules();

    abstract public function getNodeLabels();

    abstract public function getContent();

    abstract public function loadContent($node);

    abstract public function getTypeId();
}
