<?php
namespace wajox\yii2base\widgets\switcher;

class Switcher extends \yii\widgets\InputWidget
{
    public $disabled;

    public function run()
    {
        return $this->render('switcher', [
            'input' => $this,
        ]);
    }
}
