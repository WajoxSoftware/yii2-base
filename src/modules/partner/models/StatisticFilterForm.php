<?php
namespace wajox\yii2base\modules\partner\models;

use yii\base\Model;
use wajox\yii2base\helpers\DateTimeHelper;
use wajox\yii2base\models\UserSubaccount;
use wajox\yii2base\models\TrafficStream;
use wajox\yii2base\models\GoodPartnerProgram;
use wajox\yii2base\models\UserActionLog;

class StatisticFilterForm extends Model
{
    public $stepType;
    public $interval;
    public $startDate;
    public $finishDate;
    public $partnerOfferId;
    public $trafficStreamId;
    public $userSubaccountTag1;
    public $userSubaccountTag2;
    public $userSubaccountTag3;
    public $userSubaccountTag4;

    protected $user;
    protected $computedIntervalSteps = [];

    public function rules()
    {
        return [
            [['userSubaccountTag1', 'userSubaccountTag2', 'userSubaccountTag3', 'userSubaccountTag4'], 'filter', 'filter' => 'strip_tags'],
            [['userSubaccountTag1', 'userSubaccountTag2', 'userSubaccountTag3', 'userSubaccountTag4'], 'filter', 'filter' => 'trim'],
            [['startDate', 'finishDate'], 'default'],
            [['partnerOfferId', 'trafficStreamId'], 'integer'],
            [['startDate', 'finishDate'], 'date', 'format' => 'dd.mm.yyyy'],
            [['interval'], 'in', 'range' => array_keys(DateTimeHelper::getIntervalsList())],
            [['stepType'], 'in', 'range' => array_keys(DateTimeHelper::getIntervalStepsList())],
            ['interval', 'default', 'value' => DateTimeHelper::INTERVAL_TODAY],
            ['stepType', 'default', 'value' => DateTimeHelper::STEP_HOUR],
        ];
    }

    public function attributeLabels()
    {
        return [
            'startDate' => \Yii::t('app/attributes', 'From'),
            'finishDate' => \Yii::t('app/attributes', 'FromTo'),
            'interval' => \Yii::t('app/attributes', 'Statistic Dates Interval'),
            'stepType' => \Yii::t('app/attributes', 'Statistic Dates Interval Step'),
            'datesInterval' => \Yii::t('app/attributes', 'Dates Interval'),
            'partnerOfferId' => \Yii::t('app/attributes', 'Statistic Good ID'),
            'trafficStreamId' => \Yii::t('app/attributes', 'Statistic Traffic Stream ID'),
            'step' => \Yii::t('app/attributes', 'Statistic Dates Interval Step'),
            'partnerOfferTitle' => \Yii::t('app/attributes', 'Statistic Good ID'),
            'trafficStreamTitle' => \Yii::t('app/attributes', 'Statistic Traffic Stream ID'),
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
        $this->computeIntervals();
        $this->computeSteps();
    }

    public function getDatesInterval()
    {
        if ($this->interval == DateTimeHelper::INTERVAL_CUSTOM) {
            return $this->startDate . ' - ' . $this->finishDate;
        }

        $intervals = DateTimeHelper::getIntervalsList();

        return $intervals[$this->interval];
    }

    public function getStep()
    {
        $steps = DateTimeHelper::getIntervalStepsList();

        return $steps[$this->stepType];
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
        $query = $this
            ->getRepository()
            ->find(UserSubaccount::className())
            ->where([
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

    public function getTrafficStream()
    {
        if (empty($this->trafficStreamId)) {
            return;
        }

        return $this
            ->getRepository()
            ->find(TrafficStream::className())
            ->byId($this->trafficStreamId)
            ->one();
    }

    public function getPartnerOffer()
    {
        if (empty($this->partnerOfferId)) {
            return;
        }

        return $this
            ->getRepository()
            ->find(GoodPartnerProgram::className())
            ->byId($this->partnerOfferId)
            ->one();
    }

    public function getTrafficStreamTitle()
    {
        if (($model = $this->getTrafficStream()) != null) {
            return $model->title;
        }

        return;
    }

    public function getPartnerOfferTitle()
    {
        if (($model = $this->getPartnerOffer()) != null) {
            return $model->goodTitle;
        }

        return;
    }

    public function getComputedIntervalSteps()
    {
        return $this->computedIntervalSteps;
    }

    public function getExtParams()
    {
        $params = [];

        if (!empty($this->partnerOfferId)) {
            $params['offer_type_id'] = UserActionLog::OFFER_TYPE_ID_GOOD;
            $params['offer_item_id'] = $this->partnerOffer->good_id;
        }

        if (!empty($this->trafficStreamId)) {
            $params['traffic_stream_id'] = $this->trafficStreamId;
        }

        return $params;
    }
    protected function computeIntervals()
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

    protected function computeSteps()
    {
        $startAt = strtotime($this->startDate);
        $finishAt = strtotime($this->finishDate);

        $timeSize = $finishAt - $startAt;

        if ($this->interval == DateTimeHelper::INTERVAL_TODAY
            || $this->interval == DateTimeHelper::INTERVAL_YESTERDAY
        ) {
            $stepType = DateTimeHelper::STEP_ALL;
        } elseif ($this->interval == DateTimeHelper::INTERVAL_WEEK
            || $this->interval == DateTimeHelper::INTERVAL_MONTH
        ) {
            $stepType = DateTimeHelper::STEP_DAY;
        } elseif ($this->interval == DateTimeHelper::INTERVAL_HALFYEAR
            || $this->interval == DateTimeHelper::INTERVAL_YEAR
        ) {
            $stepType = DateTimeHelper::STEP_MONTH;
        } elseif ($this->interval == DateTimeHelper::INTERVAL_ALL) {
            $stepType = DateTimeHelper::STEP_ALL;
        } else {
            if (empty($this->stepType)) {
                $stepType = DateTimeHelper::STEP_MONTH;
            }

            $daySize = 24 * 3600;

            if ($timeSize > $daySize) {
                $stepType = DateTimeHelper::STEP_DAY;
            }

            if ($timeSize > $daySize * 31) {
                $stepType = DateTimeHelper::STEP_WEEK;
            }

            if ($timeSize > $daySize * 70) {
                $tstepType = DateTimeHelper::STEP_MONTH;
            }
        }

        $this->stepType = $stepType;
        $this->computedIntervalSteps = DateTimeHelper::splitByStep($stepType, $startAt, $finishAt);
    }
}
