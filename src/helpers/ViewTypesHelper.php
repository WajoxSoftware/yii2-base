<?php
namespace wajox\yii2base\helpers;

class ViewTypesHelper
{
    const VIEW_TYPE_TABLE = 'table';
    const VIEW_TYPE_CARD = 'card';
    const VIEW_TYPE_LIST = 'list';

    public static function getViewTypesList()
    {
        return [
            self::VIEW_TYPE_TABLE => \Yii::t('app', 'View Type Table'),
            self::VIEW_TYPE_CARD => \Yii::t('app', 'View Type Card'),
            self::VIEW_TYPE_LIST => \Yii::t('app', 'View Type List'),
        ];
    }

    public static function validateViewType($viewTyoe)
    {
        if (!isset(self::getViewTypesList()[$viewTyoe])) {
            return false;
        }

        return true;
    }

    public static function getViewType($viewType, $default = self::VIEW_TYPE_LIST)
    {
        if (!self::validateViewType($viewType)) {
            return $default;
        }

        return $viewType;
    }
}
