<?php
namespace wajox\yii2base\models;

class TrafficStreamPrice extends \wajox\yii2base\components\db\ActiveRecord
{
    public $finishedAt = null;
    public $startedAt = null;

    public static function tableName()
    {
        return 'traffic_stream_price';
    }

    public function rules()
    {
        return [
            [['startedAt', 'finishedAt'], 'safe'],
            [['traffic_stream_id'], 'required'],
            [['traffic_stream_id', 'started_at', 'finished_at', 'clicks_count', 'sum'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app/attributes', 'ID'),
            'traffic_stream_id' => \Yii::t('app/attributes', 'Traffic Stream ID'),
            'startedAt' => \Yii::t('app/attributes', 'From'),
            'finishedAt' => \Yii::t('app/attributes', 'FromTo'),
            'clicks_count' => \Yii::t('app/attributes', 'Traffic Stream Price Clicks Count'),
            'sum' => \Yii::t('app/attributes', 'Price'),
        ];
    }

    public function computeFinishedTime()
    {
        if ($this->finishedAt == '') {
            $this->finished_at = 0;

            return;
        }

        $this->finished_at = strtotime($this->finishedAt);
    }

    public function computeStartedTime()
    {
        if ($this->startedAt == '') {
            $this->started_at = 0;

            return;
        }

        $this->started_at = strtotime($this->startedAt);
    }

    public function getFinishedDate()
    {
        if ($this->finished_at == 0) {
            return '';
        }

        return date('d.m.Y', $this->finished_at);
    }

    public function getStartedDate()
    {
        if ($this->started_at == 0) {
            return '';
        }

        return date('d.m.Y', $this->started_at);
    }

    public function getStream()
    {
        return $this->hasOne(TrafficStream::className(), ['id' => 'traffic_stream_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // ...custom code here...
            $this->computeFinishedTime();
            $this->computeStartedTime();

            return true;
        } else {
            return false;
        }
    }

    public function getTimeInterval()
    {
        if ($this->startedDate == '' || $this->finishedDate == '') {
            return 'Время не задано';
        }

        return $this->startedDate.' - '.$this->finishedDate;
    }

    public function afterFind()
    {
        $this->startedAt = $this->getStartedDate();
        $this->finishedAt = $this->getFinishedDate();

        parent::afterFind();
    }
}
