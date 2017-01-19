<?php
namespace wajox\yii2base\traits;

trait I18nTrait
{
    public function t(string $category, string $message, array $params = [], string $language = null): string
    {
        return \Yii::t($category, $message, $params, $language);
    }
}
