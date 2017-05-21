<?php
namespace wajox\yii2base\modules\webinar\models;

use wajox\yii2base\components\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[WebinarViewer]].
 *
 * @see WebinarViewer
 */
class WebinarViewerQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return WebinarViewer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return WebinarViewer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byGuid(string $guid): WebinarViewerQuery
    {
        return $this->andWhere(['guid' => htmlspecialchars($guid)]);
    }

    public function byEmail(string $email): WebinarViewerQuery
    {
        return $this->andWhere(['email' => htmlspecialchars($email)]);
    }

    public function byUserId(int $userId): WebinarViewerQuery
    {
        return $this->andWhere(['user_id' => $userId]);
    }

    public function byWebinarId(int $webinarId): WebinarViewerQuery
    {
        return $this->andWhere(['webinar_id' => $webinarId]);
    }

    public function online(): WebinarViewerQuery
    {
        return $this->andWhere(['>=', 'last_at', time() - 300]);
    }
}
