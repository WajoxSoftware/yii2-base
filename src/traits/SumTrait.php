<?php
namespace app\traits;

trait SumTrait
{
    public function getSumRUR()
    {
        return number_format($this->sum, 2);
    }
}
