<?php
namespace wajox\yii2base\traits;

trait SumTrait
{
    public function getSumRUR()
    {
        return number_format($this->sum, 2);
    }
}
