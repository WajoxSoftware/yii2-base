<?php
namespace wajox\yii2base\widgets\fileinput;

class Fileinput extends \yii\widgets\InputWidget
{
    public $disabled;

    public function run()
    {
        return $this->render('fileinput', [
            'input' => $this,
        ]);
    }
}
