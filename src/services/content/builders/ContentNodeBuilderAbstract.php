<?php
namespace wajox\yii2base\services\content\builders;

use wajox\yii2base\models\ContentNode;
use wajox\yii2base\helpers\TextHelper;
use wajox\yii2base\components\base\Object;

abstract class ContentNodeBuilderAbstract extends Object
{
    protected $parentNode = null;
    protected $form = null;
    protected $user = null;
    protected $node = null;
    protected $request = null;
    protected $preview = null;

    public function __construct($user, $parentNode = null)
    {
        $this->setParentNode($parentNode)
             ->createForm()
             ->setUser($user);
    }

    public function save($request)
    {
        try {
            $this->setRequest($request)
                 ->validateForm()
                 ->buildNode()
                 ->saveNode();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function setNode($node)
    {
        $this->node = $node;

        if ($this->node != null) {
            $this->preview = $node->previewImage;
        }

        $this->buildForm();

        return $this;
    }
    public function getNode()
    {
        return $this->node;
    }

    public function isNew()
    {
        return $this->getNode() == null || $this->getNode()->isNewRecord;
    }

    protected function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    protected function getRequest()
    {
        return $this->request;
    }

    protected function validateForm()
    {
        if (!$this->form->load($this->getRequest()->post())) {
            throw new \Exception('Can not load form');
        }

        if (!$this->form->validate()) {
            throw new \Exception('Form data is invalid');
        }

        return $this;
    }

    protected function buildForm()
    {
        $this->form->loadContentNodeAttributes($this->getNode());
    }

    protected function buildNode()
    {
        $node = $this->getNode();

        if ($node == null) {
            $node = $this->createObject(ContentNode::className());
        }

        $node->setAttributes($this->getForm()->getContentNodeAttributes());

        if ($this->isNew()) {
            $node->created_at = time();
            $node->parent_node_id = $this->getParentNodeId();
            $node->parent_node_ids = $this->getParentNodeIds();
            $node->user_id = $this->getUser()->id;
            $node->status_id = ContentNode::STATUS_ID_NEW;
            $node->layout = ContentNode::LAYOUT_EMPTY;
        }

        $this->node = $node;

        $this->generateNodeUrl();

        return $this;
    }

    protected function saveNode()
    {
        if (!$this->node->save()) {
            throw new \Exception('Can not save node');
        }

        return $this;
    }

    protected function setForm($form)
    {
        $this->form = $form;

        return $this;
    }

    protected function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    protected function getUser()
    {
        return $this->user;
    }

    public function setParentNode($parentNode)
    {
        $this->parentNode = $parentNode;

        return $this;
    }

    protected function getParentNode()
    {
        return $this->parentNode;
    }

    protected function getParentNodeId()
    {
        if ($this->getParentNode() == null) {
            return 0;
        }

        return $this->getParentNode()->id;
    }

    protected function getParentNodeIds()
    {
        if ($this->getParentNodeId() == 0) {
            return;
        }

        $ids = explode(',', $this->getParentNode()->parent_node_ids);
        $ids[] = $this->getParentNodeId();

        return implode(',', $ids);
    }

    protected function generateNodeUrl()
    {
        $url = TextHelper::str2url($this->getNode()->url);

        if (empty($url)) {
            $url = TextHelper::str2url($this->getNode()->title);
        }

        if (empty($url)) {
            return;
        }

        if (!$this->isUrlExists($url)) {
            $this->node->url = $url;

            return;
        }

        $uniqId = $this->isNew() ? uniqid() : $this->getNode()->id;
        $url = TextHelper::str2url($url, $uniqId);

        if (!$this->isUrlExists($url)) {
            $this->node->url = $url;

            return;
        }
    }

    protected function isUrlExists($url)
    {
        $query = ContentNode::find()->where(['url' => $url]);

        if (!$this->isNew()) {
            $query = $query->andWhere(['!=', 'id', $this->getNode()->id]);
        }

        return $query->exists();
    }

    abstract protected function createForm();
}
