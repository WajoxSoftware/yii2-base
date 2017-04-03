<?php
namespace wajox\yii2base\commands;

use yii\console\Controller;
use wajox\yii2base\models\SettingOption;
use wajox\yii2base\services\settings\SettingsManager;

class SenderSettingsController extends Controller
{
    public function actionCreate()
    {
        $manager = new SettingsManager();
        foreach ($this->getSettings() as $key => $item) {
            $manager->save($key, $item['value'], $item['type_id']);
        }
    }

    protected function getSettings()
    {
        $params = [
            'endpoint_url' => 'https://api2.esv2.com/Api/',
            'api_key' => '5RhLodq9D9oEhHVduhpv',
            'transactional_id' => '37',
            'base_list_id' => '5',
        ];

        $queryParts = [];

        foreach ($params as $k => $v) {
            $queryParts[] = $k . '=' . urlencode($v);
        }

        return  [
            'app_mail_adapter_class' => [
                'value' => '\wajox\yii2base\services\mail\ExpertSenderAdapter',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],
            'app_mail_adapter_from' => [
                'value' => 'support@example.com',
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],
            'app_mail_adapter_params' => [
                'value' => implode('&', $queryParts),
                'type_id' => SettingOption::TYPE_ID_STRING,
            ],
        ];
    }
}
