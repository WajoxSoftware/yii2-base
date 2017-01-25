<?php
namespace wajox\yii2base\events\types;

use yii\base\Event;

class StatisticEvent extends Event
{
    const EVENT_NEW = 'new_view';

    public $statistic;
}
