<?php
namespace wajox\yii2base\traits;

trait StatusAtTrait
{
    public function getStatusDate()
    {
        return date('d.m.Y', $this->status_at);
    }

    public function getStatusTime()
    {
        return date('H:i', $this->status_at);
    }

    public function getStatusDateTime()
    {
        return date('d.m.Y H:i', $this->status_at);
    }
}
