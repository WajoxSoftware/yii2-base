<?php
namespace wajox\yii2base\traits;

trait UpdatedAtTrait
{
    public function getUpdatedDate(): string
    {
        return date('d.m.Y', $this->updated_at);
    }

    public function getUpdatedTime(): string
    {
        return date('H:i', $this->updated_at);
    }

    public function getUpdatedDateTime(): string
    {
        return date('d.m.Y H:i', $this->updated_at);
    }
}
