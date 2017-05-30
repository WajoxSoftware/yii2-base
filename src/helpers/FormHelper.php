<?php
namespace wajox\yii2base\helpers;

class FormHelper
{
    public static function renderRurPriceField($form, $model, $field)
    {
        $tpl = '<table class="table unstyled" border="0" cellpadding="0" cellspacing="0"><tr><td>{input}</td><td><div class="field-postfix">P</div></td></tr></table>';

        return $form->field($model, $field, ['inputTemplate' => $tpl]);
    }

    public static function renderUrlPartField($form, $model, $field, $routeParams = ['/'])
    {
        $url = \yii\helpers\Url::toRoute($routeParams, true);

        $tpl = '<table class="table unstyled" border="0" cellpadding="0" cellspacing="0"><tr><td nowrap><div class="field-prefix">' . $url . '</div></td><td width="100%">{input}</td></tr></table>';

        return $form->field($model, $field, ['inputTemplate' => $tpl]);
    }

    public static function renderPrefixField($form, $model, $field, $prefix)
    {
        $tpl = '<table class="table unstyled" border="0" cellpadding="0" cellspacing="0"><tr><td nowrap><div class="field-prefix">' . $prefix . '</div></td><td width="100%">{input}</td></tr></table>';

        return $form->field($model, $field, ['inputTemplate' => $tpl]);
    }
}
