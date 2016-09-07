<?php
namespace wajox\yii2base\helpers;

class FormHelper
{
    public static function renderRurPriceField($form, $model, $field)
    {
        $tpl = '<div class="input-group">{input}<span class="input-group-addon">P</span></div>';

        return $form->field($model, $field, ['inputTemplate' => $tpl]);
    }

    public static function renderUrlPartField($form, $model, $field, $routeParams = ['/'])
    {
        $url = \yii\helpers\Url::toRoute($routeParams, true);

        $tpl = '<div class="input-group"><span class="input-group-addon">' . $url . '</span>{input}</div>';

        return $form->field($model, $field, ['inputTemplate' => $tpl]);
    }

    public static function renderPrefixField($form, $model, $field, $prefix)
    {
        $tpl = '<div class="input-group"><span class="input-group-addon">' . $prefix . '</span>{input}</div>';

        return $form->field($model, $field, ['inputTemplate' => $tpl]);
    }
}
