<?php
namespace wajox\yii2base\modules\shop\services;

use wajox\yii2base\modules\shop\models\GoodLetterEmail;
use wajox\yii2base\components\base\Object;

class GoodLetterEmailsSender extends Object
{
    const LIMIT = 1000;

    public function run()
    {
        foreach ($this->getEmailsQuery()->each() as $letterEmail) {
            $this->sendEmail($letterEmail);
        }
    }

    protected function getEmailsQuery()
    {
        return $this
            ->getRepository()
            ->find(GoodLetterEmail::className())
            ->where([
                'status_id' => GoodLetterEmail::STATUS_ID_NEW,
            ])
            ->andWhere([
                '<=',
                'scheduled_at',
                time(),
            ])
            ->limit(self::LIMIT);
    }

    protected function sendEmail($model)
    {
        $mailer = $this->createObject(
            GoodLettersMailer::className(),
            [$model]
        );
        
        $result = $mailer->send();

        $model->status_id = $result ? GoodLetterEmail::STATUS_ID_SEND : GoodLetterEmail::STATUS_ID_ERROR;
        $model->send_at = time();
        
        return $model->save();
    }
}
