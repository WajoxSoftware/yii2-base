<?php
namespace wajox\yii2base\services\uploads;

class FileStatuses
{
    const STATUS_ID_VISIBLE = 100;
    const STATUS_ID_HIDDEN = 101;
    const STATUS_ID_TRASH = 102;
    const STATUS_ID_TEMP = 103;

    public static function getAvailableStatusIdList()
    {
        return [
            self::STATUS_ID_TEMP,
            self::STATUS_ID_TRASH,
            self::STATUS_ID_HIDDEN,
            self::STATUS_ID_VISIBLE,
        ];
    }
}
