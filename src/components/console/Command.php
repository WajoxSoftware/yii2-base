<?php
namespace wajox\yii2base\components\console;

class Command
{
    protected $command;
    protected $params = [];
    
    public function __construct($command, $params = [])
    {
        $this->command = $command;
        $this->params = $params;
    }

    public function run($async = false)
    {
        $params = [];
        foreach ($this->params as $key => $param) {
            $params[$key] = '"' . $param . '"';
        }

        $cmd = 'php ' . \Yii::getAlias('@app/yii')
            . ' ' . $this->command
            . ' ' . implode(' ', $params);
            . ($async ? ' >> /dev/null &' : '');

        return shell_exec($cmd);
    }
}
