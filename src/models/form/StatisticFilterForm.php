<?php
namespace wajox\yii2base\models\form;

use wajox\yii2base\components\base\Model;
use wajox\yii2base\helpers\DateTimeHelper;
use wajox\yii2base\models\UserSubaccount;

class StatisticFilterForm extends Model
{
    const INTERVAL_CUSTOM = 'custom';
    const INTERVAL_TODAY = 'today';
    const INTERVAL_YESTERDAY = 'yesterday';
    const INTERVAL_WEEK = 'week';
    const INTERVAL_MONTH = 'month';
    const INTERVAL_ALL = 'all';

    public $interval;
    public $startDate;
    public $finishDate;
    public $userSubaccountTag1;
    public $userSubaccountTag2;
    public $userSubaccountTag3;
    public $userSubaccountTag4;

    protected $user;

    public function rules()
    {
        return [
            [['userSubaccountTag1', 'userSubaccountTag2', 'userSubaccountTag3', 'userSubaccountTag4'], 'filter', 'filter' => 'strip_tags'],
            [['userSubaccountTag1', 'userSubaccountTag2', 'userSubaccountTag3', 'userSubaccountTag4'], 'filter', 'filter' => 'trim'],
            [['startDate', 'finishDate'], 'default'],
            [['startDate', 'finishDate'], 'date', 'format' => 'dd.mm.yyyy'],
            [['interval'], 'in', 'range' => array_keys(self::getIntervalsList())],
            ['interval', 'default', 'value' => self::INTERVAL_TODAY],
        ];
    }

    public function attributeLabels()
    {
        return [
            'startDate' => \Yii::t('app/attributes', 'From'),
            'finishDate' => \Yii::t('app/attributes', 'FromTo'),
            'interval' => \Yii::t('app/attributes', 'Dates Interval'),
            'datesInterval' => \Yii::t('app/attributes', 'Dates Interval'),
            'userSubaccountTag' => \Yii::t('app/attributes', 'User Subaccount Tag'),
            'userSubaccountTag1' => \Yii::t('app/attributes', 'User Subaccount Tag1'),
            'userSubaccountTag2' => \Yii::t('app/attributes', 'User Subaccount Tag2'),
            'userSubaccountTag3' => \Yii::t('app/attributes', 'User Subaccount Tag3'),
            'userSubaccountTag4' => \Yii::t('app/attributes', 'User Subaccount Tag4'),
        ];
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

    public function getUserId()
    {
        if ($this->user) {
            return $this->user->id;
        }

        return 0;
    }

    public function compute()
    {
        $intervals = DateTimeHelper::computeIntervals(
            $this->interval,
            $this->startDate,
            $this->finishDate
        );

        $this->interval = $intervals['interval'];
        $this->startDate = $intervals['start_date'];
        $this->finishDate = $intervals['finish_date'];
    }

    public static function getIntervalsList()
    {
        return [
            self::INTERVAL_CUSTOM => \Yii::t('app/general', 'Custom'),
            self::INTERVAL_TODAY => \Yii::t('app/general', 'Today'),
            self::INTERVAL_YESTERDAY => \Yii::t('app/general', 'Yesterday'),
            self::INTERVAL_WEEK => \Yii::t('app/general', 'Week'),
            self::INTERVAL_MONTH => \Yii::t('app/general', 'Month'),
            self::INTERVAL_ALL => \Yii::t('app/general', 'All'),
        ];
    }

    public function getDatesInterval()
    {
        if ($this->interval == self::INTERVAL_CUSTOM) {
            return $this->startDate . ' - ' . $this->finishDate;
        }

        $intervals = $this->getIntervalsList();

        return $intervals[$this->interval];
    }

    public function getUserSubaccountTag()
    {
        $tags = [
            $this->userSubaccountTag1,
            $this->userSubaccountTag2,
            $this->userSubaccountTag3,
            $this->userSubaccountTag4,
        ];

        $tags = array_filter($tags);

        if (sizeof($tags) == 0) {
            return;
        }

        return '/' . implode('/', $tags);
    }

    public function getUserSubaccountIds()
    {
        $tag = $this->getUserSubaccountTag();
        $ids = [];
        $query = $this->findUserSubaccountsByTags();

        if ($query->count() == 0) {
            if (!empty($tag)) {
                return '0';
            } else {
                return;
            }

            return;
        }

        foreach ($query->each() as $id => $model) {
            $ids[] = $id;
        }

        return implode(',', $ids);
    }

    public function findUserSubaccountsByTags()
    {
        $query = UserSubaccount::find()->where([
                'user_id' => $this->getUser()->id,
            ]);

        if (!empty($this->userSubaccountTag1)) {
            $query->andWHere(['like', 'tag1', $this->userSubaccountTag1]);
        }

        if (!empty($this->userSubaccountTag2)) {
            $query->andWHere(['like', 'tag2', $this->userSubaccountTag2]);
        }

        if (!empty($this->userSubaccountTag3)) {
            $query->andWHere(['like', 'tag3', $this->userSubaccountTag3]);
        }

        if (!empty($this->userSubaccountTag4)) {
            $query->andWHere(['like', 'tag4', $this->userSubaccountTag4]);
        }

        return $query->indexBy('id');
    }
}