<?php
namespace wajox\yii2base\services\system;

use yii\base\Component;
use wajox\yii2base\models\SettingOption;

class SettingsManager extends Component
{
    public $items = [];

    public function saveStr($key, $value)
    {
        return $this->save($key, $value, SettingOption::TYPE_ID_STRING);
    }

    public function saveBool($key, $value)
    {
        return $this->save($key, $value, SettingOption::TYPE_ID_BOOL);
    }

    public function saveInt($key, $value)
    {
        return $this->save($key, $value, SettingOption::TYPE_ID_INTEGER);
    }

    public function saveNum($key, $value)
    {
        return $this->save($key, $value, SettingOption::TYPE_ID_NUMERIC);
    }

    public function exists($key)
    {
        return $this->get($key) != null;
    }

    public function get($key, $default = '')
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }

        $model = $this->find($key);

        if ($model == null) {
            return $default;
        }

        $this->add($model);

        return $model->value;
    }

    public function delete($key)
    {
        $model = $this->find($key);

        if ($model == null) {
            return false;
        }

        return $model->delete();
    }

    public function find($key)
    {
        return SettingOption::find()->where(['key' => $key])->one();
    }

    public function load()
    {
        $q = SettingOption::find();

        foreach ($q->each() as $model) {
            $this->add($model);
        }

        return $this;
    }

    public function all()
    {
        return $this->items;
    }

    public function save($key, $value, $typeId = SettingOption::TYPE_ID_STRING)
    {
        $model = $this->find($key);

        if ($model == null) {
            $model = \Yii::createObject(SettingOption::className());
        }

        $model->type_id = $typeId;
        $model->key = $key;
        $model->setValue($value);

        if (!$model->save()) {
            return false;
        }

        $this->add($model);

        return true;
    }

    protected function add($model)
    {
        $this->items[$model->key] = $model;

        return $this;
    }
}
