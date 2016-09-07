<?php
namespace app\traits;

trait UpdatedAtTrait
{
    public function getUpdatedDate()
    {
        return date('d.m.Y', $this->updated_at);
    }

    public function getUpdatedTime()
    {
        return date('H:i', $this->updated_at);
    }

    public function getUpdatedDateTime()
    {
        return date('d.m.Y H:i', $this->updated_at);
    }
}
