<?php
namespace wajox\yii2base\modules\webinar\models;

use wajox\yii2base\components\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Webinar]].
 *
 * @see Webinar
 */
class WebinarQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Webinar[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Webinar|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
