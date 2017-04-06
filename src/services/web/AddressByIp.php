<?php
namespace wajox\yii2base\services\web;

use wajox\yii2base\components\base\Object;

class AddressByIp extends Object
{
    const STATUS_FAILED = 'fail';
    const GEODECODER_URL  = 'http://ip-api.com/json/';

    public static function getDetailed($ip)
    {
        $geo = self::get($ip);

        if ($geo == null) {
            return;
        }

        return $geo->country.', '.$geo->regionName.', '.$geo->city;
    }

    public static function get($ip)
    {
        return;
        
        try {
            $geo = json_decode(file_get_contents(self::GEODECODER_URL.$ip));
        } catch (\Exсeption $e) {
            return;
        }

        if ($geo->status == self::STATUS_FAILED) {
            return;
        }

        return $geo;
    }
}
