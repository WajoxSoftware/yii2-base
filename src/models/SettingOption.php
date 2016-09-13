<?php
namespace wajox\yii2base\models;

class SettingOption extends wajox\yii2base\components\db\ActiveRecord
{
    const TYPE_ID_STRING = 100;
    const TYPE_ID_INTEGER = 200;
    const TYPE_ID_NUMERIC = 300;
    const TYPE_ID_BOOL = 400;
    const BOOL_VAL_TRUE = 'true';
    const BOOL_VAL_FALSE = 'false';

    public static function tableName()
    {
        return 'setting_option';
    }

    public function rules()
    {
        return [
            [['key', 'val', 'type_id'], 'required'],
            [['val'], 'string'],
            [['type_id'], 'integer'],
            [['key'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'key' => $this->t('app/attributes', 'Setting Option Key'),
            'val' => $this->t('app/attributes', 'Setting Option Value'),
            'type_id' => $this->t('app/attributes', 'Setting Option Type ID'),
        ];
    }

    public function getStrValue()
    {
        return $this->val;
    }

    public function getBoolValue()
    {
        return ($this->val == self::BOOL_VAL_TRUE);
    }

    public function getIntValue()
    {
        return intval($this->val);
    }

    public function getNumValue()
    {
        return floatval($this->val);
    }

    public function getValue()
    {
        if ($this->type_id == self::TYPE_ID_BOOL) {
            return $this->boolValue;
        }

        if ($this->type_id == self::TYPE_ID_INTEGER) {
            return $this->intValue;
        }

        if ($this->type_id == self::TYPE_ID_NUMERIC) {
            return $this->numValue;
        }

        if ($this->type_id == self::TYPE_ID_STRING) {
            return $this->strValue;
        }

        return;
    }

    public function __toString()
    {
        return $this->getValue();
    }

    public function setValue($value)
    {
        if ($this->type_id == self::TYPE_ID_STRING) {
            $this->val = $value;
        }

        if ($this->type_id == self::TYPE_ID_BOOL) {
            $this->val = $value ? SettingOption::BOOL_VAL_TRUE : SettingOption::BOOL_VAL_FALSE;
        }

        if ($this->type_id == self::TYPE_ID_INTEGER) {
            $this->val = intval($value);
        }

        if ($this->type_id == self::TYPE_ID_NUMERIC) {
            $this->val = floatval($value);
        }

        $this->val = $this->val . '';

        return;
    }
}
