<?php
namespace wajox\yii2base\modules\webinar\models;

/**
 * This is the model class for table "webinar".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $start_datetime
 * @property string $finish_datetime
 * @property string $video
 * @property int $advert_time
 * @property string $advert
 * @property int $max_viewers_count
 * @property int $views_count
 * @property int $created_at
 *
 * @property WebinarMessage[] $webinarMessages
 */
class Webinar extends \wajox\yii2base\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'webinar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'advert_time', 'max_viewers_count', 'views_count', 'created_at'], 'integer'],
            [['advert'], 'string'],
            [['title', 'start_datetime', 'finish_datetime'], 'string', 'max' => 255],
            [['video'], 'string', 'max' => 800],
            [['names_dictionary'], 'string', 'max' => 65000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'user_id' => \Yii::t('app/attributes', 'User ID'),
            'title' => \Yii::t('app/attributes', 'Title'),
            'start_datetime' => \Yii::t('app/attributes', 'Start Datetime'),
            'finish_datetime' => \Yii::t('app/attributes', 'Finish Datetime'),
            'video' => \Yii::t('app/attributes', 'Video'),
            'advert_time' => \Yii::t('app/attributes', 'Advert Time'),
            'advert' => \Yii::t('app/attributes', 'Advert'),
            'max_viewers_count' => \Yii::t('app/attributes', 'Max Viewers Count'),
            'views_count' => \Yii::t('app/attributes', 'Views Count'),
            'created_at' => \Yii::t('app/attributes', 'Created At'),
            'names_dictionary' => \Yii::t('app/attributes', 'Names Dictionary'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarMessages()
    {
        return $this->hasMany(
            WebinarMessage::className(),
            ['webinar_id' => 'id']
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarViewers()
    {
        return $this->hasMany(
            WebinarViewer::className(),
            ['webinar_id' => 'id']
        );
    }

    /**
     * @inheritdoc
     * @return WebinarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WebinarQuery(get_called_class());
    }

    public function getStartAt(): int
    {
        return strtotime($this->start_datetime);
    }

    public function getFinishAt(): int
    {
        return strtotime($this->finish_datetime);
    }

    public function getStartOffset(): int
    {
        return time() - $this->getStartAt();
    }

    public function getFinishOffset(): int
    {
        return time() - $this->getFinishAt();
    }

    public function getIsStarted(): bool
    {
        return $this->getStartOffset() > 0
            && !$this->getIsFinished();
    }

    public function getIsFinished(): bool
    {
        return $this->getFinishOffset() > 0;
    }

    public function getDuration(): int
    {
        return $this->getFinishAt() - $this->getStartAt();
    }

    public function getCurrentTime(): int
    {
        return time() - $this->getStartAt();
    }

    public function getIsActive(): bool
    {
        return $this->isStarted && !$this->isFinished;
    }

    public function getIsAdvertEnabled(): bool
    {
        return $this->getStartAt() + $this->advert_time < time()
            && $this->getFinishAt() + 60 * 15 > time();
    }

    public function getStartDateTime(): string
    {
        return date('d.m.Y H:i:s', $this->startAt);
    }

    public function getFinishDateTime(): string
    {
        return date('d.m.Y H:i:s', $this->finishAt);
    }

    public function getNamesDictionaryArray(): array
    {
        return array_map('trim', explode("\n", $this->names_dictionary));
    }
}
