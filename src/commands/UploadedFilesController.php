<?php
namespace wajox\yii2base\commands;

use yii\console\Controller;
use wajox\yii2base\models\UploadedFIle;
use wajox\yii2base\services\uploads\FileStatuses;

class UploadedFilesController extends Controller
{
    const FILES_LIFETIME = 3600;

    public function actionClean()
    {
        $statuses = [
            FileStatuses::STATUS_ID_TRASH,
            FileStatuses::STATUS_ID_TEMP,
        ];

        $q = UploadedFile::find()
                ->where(['status_id' => $statuses])
                ->andWhere([
                    '<=',
                    'created_at',
                    time() - self::FILES_LIFETIME,
                ]);

        foreach ($q->each() as $file) {
            $file->delete();
        }
    }
}
