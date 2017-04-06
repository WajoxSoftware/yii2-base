<?php
namespace wajox\yii2base\components\console;

use wajox\yii2base\components\base\Object;

class CommandsManager extends Object
{
    public function run($cmd, $params, $async = false)
    {
        return (new Command($cmd, $params))->run($async);
    }
}
