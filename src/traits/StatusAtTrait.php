<?php
namespace wajox\yii2base\traits;

trait StatusAtTrait
{
    public function getStatusDate(): string
    {
        return date('d.m.Y', $this->status_at);
    }

    public function getStatusTime(): string
    {
        return date('H:i', $this->status_at);
    }

    public function getStatusDateTime(): string
    {
        return date('d.m.Y H:i', $this->status_at);
    }
}
