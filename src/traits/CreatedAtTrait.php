<?php
namespace wajox\yii2base\traits;

trait CreatedAtTrait
{
    public function getCreatedDate(): string
    {
        return date('d.m.Y', $this->created_at);
    }

    public function getCreatedTime(): string
    {
        return date('H:i', $this->created_at);
    }

    public function getCreatedDateTime(): string
    {
        return date('d.m.Y H:i', $this->created_at);
    }
}
