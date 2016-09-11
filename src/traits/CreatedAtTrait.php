<?php
namespace wajox\yii2base\traits;

trait CreatedAtTrait
{
    public function getCreatedDate()
    {
        return date('d.m.Y', $this->created_at);
    }

    public function getCreatedTime()
    {
        return date('H:i', $this->created_at);
    }

    public function getCreatedDateTime()
    {
        return date('d.m.Y H:i', $this->created_at);
    }
}
