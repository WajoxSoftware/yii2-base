<?php
namespace wajox\yii2base\models\form;

use wajox\yii2base\modules\content\models\ContentNode;

class CatalogForm extends ContentNodeFormAbstract
{
    public $content_html;

    public function getNodeRules()
    {
        return [
                [['content_html'], 'string'],
            ];
    }

    public function getNodeLabels()
    {
        return [
                'content_html' => \Yii::t('app/attributes', 'Content'),
            ];
    }

    public function getContent()
    {
        return [
            'content_html' => $this->content_html,
        ];
    }

    public function loadContent($node)
    {
        $this->content_html = $node->content['content_html'];
    }

    public function getTypeId()
    {
        return ContentNode::TYPE_ID_CATALOG;
    }
}
