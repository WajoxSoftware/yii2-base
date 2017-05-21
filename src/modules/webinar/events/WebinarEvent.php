<?php
namespace wajox\yii2base\modules\webinar\events;

use yii\base\Event;

class WebinarEvent extends Event
{
    const EVENT_VIEW_STARTED = 'viewStarted';
    const EVENT_VIEW_FINSIHED = 'viewFinished';
    const EVENT_ADVERT_DISPLAYED = 'viewAdvert';

    public $webinar;
}
