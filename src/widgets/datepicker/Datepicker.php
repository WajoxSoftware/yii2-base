<?php
namespace wajox\yii2base\widgets\datepicker;

class Datepicker extends \yii\widgets\InputWidget
{
    public $disabled;
    public $datepickerOptions = [];

    public function run()
    {
        return $this->render('datepicker', [
            'input' => $this,
            'options' => $this->datepickerOptions,
        ]);
    }
}
