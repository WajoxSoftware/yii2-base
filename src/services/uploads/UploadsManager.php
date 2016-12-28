<?php
namespace wajox\yii2base\services\uploads;

use wajox\yii2base\models\UploadedFile as UploadedFileModel;
use wajox\yii2base\models\UploadedImage as UploadedImageModel;
use yii\web\UploadedFile;
use wajox\yii2base\components\base\Object;

class UploadsManager extends Object
{
    public $user = null;
    public $status_id = null;

    public function __construct($user = null)
    {
        $this->setUser($user);
    }

    public function saveImage($request)
    {
        return $this->save($request, FileTypes::TYPE_ID_IMAGE);
    }

    public function save($request, $type = null)
    {
        $model = $this->buildModel($type);

        return $this->processRequest($model, $request);
    }

    public function replace($model, $request)
    {
        return $this->processRequest($model, $request);
    }

    protected function processRequest($model, $request)
    {
        $model->load($request->post());
        $model->created_at = time();
        $model->user_id = $this->getUser()->id;
        $model->type_id = $this->getTypeId($model);
        $model->status_id = $this->getStatusId();
        $model->size = $this->getSize($model);

        if (!$model->validate()) {
            return $model;
        }

        $model->save();

        return $model;
    }

    public function show($ids)
    {
        $this->updateStatusId(
            $this->filterIds($ids),
            FileStatuses::STATUS_ID_VISIBLE
        );
    }

    public function hide($ids)
    {
        $this->updateStatusId(
            $this->filterIds($ids),
            FileStatuses::STATUS_ID_HIDDEN
        );
    }

    public function moveToTrash($ids)
    {
        $this->updateStatusId(
            $this->filterIds($ids),
            FileStatuses::STATUS_ID_TRASH
        );
    }

    public function markAsTemp($ids)
    {
        $this->updateStatusId(
            $this->filterIds($ids),
            FileStatuses::STATUS_ID_TEMP
        );
    }

    public function remove($ids)
    {
        $query = $this
            ->getRepository()
            ->find(UploadedFileModel::className())
            ->where([
                'user_id' => $this->getUser()->id,
                'id' => $this->filterIds($ids),
            ]);

        foreach ($query->each() as $model) {
            $model->delete();
        }

        return true;
    }

    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function getUser()
    {
        if (empty($this->user)) {
            throw new \Exception('user not defined');
        }

        return $this->user;
    }

    public function setStatusId($statusId)
    {
        $this->statusId = $statusId;

        return $this;
    }

    public function getStatusId()
    {
        if (empty($this->statusId)) {
            return FileStatuses::STATUS_ID_TEMP;
        }

        return $this->statusId;
    }

    public function getSize($model)
    {
        $file = UploadedFile::getInstance($model, 'file');

        if (empty($file)) {
            return 0;
        }

        return $file->size;
    }

    public function getTypeId($model)
    {
        $file = UploadedFile::getInstance($model, 'file');

        if (empty($file)) {
            return FileTypes::TYPE_ID_UNKNOWN;
        }

        return FileTypes::detectTypeIdByExtension($file->extension);
    }

    protected function filterIds($ids)
    {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        foreach ($ids as $i => $v) {
            $ids[$i] = intval($v);
        }

        return $ids;
    }

    protected function buildModel($type)
    {
        if ($type == FileTypes::TYPE_ID_IMAGE) {
            return $this->createObject(UploadedImageModel::className());
        }

        return $this->createObject(UploadedFileModel::className());
    }

    protected function updateStatusId($ids, $statusId)
    {
        $this
            ->getRepository()
            ->update(
                UploadedFileModel::className(),
                ['status_id' => $statusId],
                [
                    'user_id' => $this->getUser()->id,
                    'id' => $ids,

                ]
            );
    }
}
