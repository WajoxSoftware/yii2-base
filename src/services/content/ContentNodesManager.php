<?php
namespace wajox\yii2base\services\content;

use wajox\yii2base\models\ContentNode;
use wajox\yii2base\services\uploads\UploadsManager;
use wajox\yii2base\components\base\Object;

class ContentNodesManager extends Object
{
    protected $user;
    protected $builder;

    public function __construct($user)
    {
        $this->setUser($user);
    }

    public function setNode($node)
    {
        return $this->initBuilder($node);
    }

    public function setTypeId($typeId)
    {
        $node = $this->createObject(ContentNode::className());
        $node->type_id = $typeId;

        return $this->setNode($node);
    }

    public function getBuilder()
    {
        return $this->builder;
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

    public function getForm()
    {
        return $this->getBuilder()->getForm();
    }

    public function getNode()
    {
        return $this->getBuilder()->getNode();
    }

    public function create($request, $parentNodeId = 0)
    {
        return $this->saveNode($request, $parentNodeId);
    }

    public function update($request)
    {
        return $this->saveNode($request);
    }

    public function publish()
    {
        return $this->updateStatus(ContentNode::STATUS_ID_PUBLISHED);
    }

    public function archive()
    {
        return $this->updateStatus(ContentNode::STATUS_ID_ARCHIVE);
    }

    public function remove()
    {
        $this->deletePreview();
        $this->getNode()->delete();

        return true;
    }

    public function savePreview($request)
    {
        $node = $this->getNode();

        if ($node->isNewRecord) {
            throw new \Exception('Content Node must be stored before!');
        }

        $preview = $node->previewImage;

        if ($preview != null) {
            $model = $this->getUploadsManager()->replace($preview, $request);
        } else {
            $model = $this->getUploadsManager()->saveImage($request);
        }

        $node->preview_image_id = $model->id;
        $node->save();

        $this->getUploadsManager()->show($model->id);

        return $model;
    }

    public function deletePreview()
    {
        return $this->getUploadsManager()->remove($this->getNode()->preview_image_id);
    }

    public function addFile($request, $type = null)
    {
        $model = $this->getUploadsManager()->save($request, $type);

        if (!$model) {
            return;
        }

        $modelFile = $this->createObject(ContentNodeFile::className());
        $modelFile->content_node_id = $this->getNode()->id;
        $modelFile->uploaded_file_id = $model->id;

        if (!$modelFile->save()) {
            return;
        }

        $this->getUploadsManager()->show($model->id);

        return $model;
    }

    public function removeFile($id)
    {
        $model = ContentNodeFile::findOne($id);

        if ($model == null) {
            throw new \Exception('Content Node File did not found');
        }

        $this->getUploadsManager()->remove($model->uploaded_file_id);

        if (!$model->delete()) {
            return false;
        }

        return true;
    }

    protected function updateStatus($statusId)
    {
        $node = $this->getNode();
        $node->status_id = $statusId;
        $node->save();

        return $this;
    }

    protected function saveNode($request, $parentNodeId = 0)
    {
        $parentNode = null;

        if ($parentNodeId != 0) {
            $parentNode = $this->findNode($parentNodeId);
        }

        return $this->getBuilder()->setParentNode($parentNode)->save($request);
    }

    protected function findNode($id)
    {
        if (($model = ContentNode::findOne($id)) == null) {
            throw new \Exception('ContentNode not found');
        }

        return $model;
    }

    protected function setBuilder($builder)
    {
        $this->builder = $builder;

        return $this;
    }

    protected function initBuilder($node)
    {
        $builderClass = '\wajox\yii2base\services\content\builders\\'
            . $this->getBuildersList()[$node->type_id];

        $builder = $this->createObject($builderClass, [$this->getUser()]);
        $builder->setNode($node);

        $this->setBuilder($builder);

        return $this;
    }

    protected function getBuildersList()
    {
        return [
            ContentNode::TYPE_ID_CATALOG => 'CatalogBuilder',
            ContentNode::TYPE_ID_PAGE => 'PageBuilder',
        ];
    }

    protected function getUploadsManager()
    {
        return $this->createObject(UploadsManager::className(), [$this->getUser()]);
    }
}
