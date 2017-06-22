<?php
namespace wajox\yii2base\modules\webinar\models;

/**
 * This is the model class for table "webinar_viewer".
 *
 * @property int $id
 * @property string $name
 * @property string $guid
 * @property string $email
 * @property int $user_id
 * @property int $created_at
 */
class WebinarViewer extends \wajox\yii2base\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'webinar_viewer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['webinar_id', 'name', 'email', 'guid'], 'required'],
            [['user_id', 'webinar_id', 'created_at'], 'integer'],
            [['name', 'guid', 'email'], 'string', 'max' => 255],
            [['email', 'name'], 'filter', 'filter' => 'strip_tags'],
            [['email', 'name'], 'filter', 'filter' => 'htmlentities'],
            [['email', 'name'], 'filter', 'filter' => 'trim'],
            [['email'], 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'name' => \Yii::t('app/attributes', 'Name'),
            'guid' => \Yii::t('app/attributes', 'Guid'),
            'email' => \Yii::t('app/attributes', 'Email'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'webinar_id' => \Yii::t('app/attributes', 'Webinar ID'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
            'last_at' => \Yii::t('app/attributes', 'Last At'),
        ];
    }

    /**
     * @inheritdoc
     * @return WebinarViewerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WebinarViewerQuery(get_called_class());
    }
}
