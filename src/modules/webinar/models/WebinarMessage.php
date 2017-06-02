<?php
namespace wajox\yii2base\modules\webinar\models;

use wajox\yii2base\models\User;

/**
 * This is the model class for table "webinar_message".
 *
 * @property int $id
 * @property int $webinar_id
 * @property int $user_id
 * @property string $guid
 * @property string $name
 * @property string $email
 * @property string $message
 * @property int $created_at
 *
 * @property Webinar $webinar
 */
class WebinarMessage extends \wajox\yii2base\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'webinar_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['webinar_id', 'user_id', 'created_at'], 'integer'],
            [['guid', 'name', 'email'], 'string', 'max' => 255],
            [['message'], 'string', 'max' => 500],
            [['webinar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Webinar::className(), 'targetAttribute' => ['webinar_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'webinar_id' => \Yii::t('app', 'Webinar ID'),
            'user_id' => \Yii::t('app', 'User ID'),
            'guid' => \Yii::t('app', 'Guid'),
            'name' => \Yii::t('app', 'Name'),
            'email' => \Yii::t('app', 'Email'),
            'message' => \Yii::t('app', 'Message'),
            'created_at' => \Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinar()
    {
        return $this->hasOne(Webinar::className(), ['id' => 'webinar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarViewer()
    {
        return $this->hasOne(WebinarViewer::className(), [
            'guid' => 'guid',
            'email' => 'email',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * @inheritdoc
     * @return WebinarMessageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WebinarMessageQuery(get_called_class());
    }
}
