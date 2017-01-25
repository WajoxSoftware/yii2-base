<?php
namespace wajox\yii2base\events;

use yii\base\Event;

class StatisticEvent extends Event
{
    const EVENT_NEW = 'view';

    public $statistic;
}
