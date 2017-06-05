<?php
namespace wajox\yii2base\services\settings;

use wajox\yii2base\models\SettingOption;
use wajox\yii2base\components\base\Component;

class SettingsManager extends Component
{
    public $items = [];

    public function init()
    {
        $this->load();
    }

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
            $model = $this->items[$key];
            ;
        } else {
            $model = $this->find($key);
            $this->add($model);
        }

        if ($model == null) {
            return $default;
        }

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
        return $this
            ->getRepository()
            ->find(SettingOption::className())
            ->where(['key' => $key])
            ->one();
    }

    public function load()
    {
        $q = $this
                ->getRepository()
                ->find(SettingOption::className());

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
            $model = $this->createObject(SettingOption::className());
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
