<?php
namespace wajox\yii2base\traits;

trait I18nTrait
{
    public function t($category, $message, $params = [], $language = null)
    {
        return \Yii::t($category, $message, $params, $language);
    }
}
