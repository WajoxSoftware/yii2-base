<?php
namespace wajox\yii2base\services\traffic;

class TrafficTunnelSources extends \wajox\yii2base\components\base\Object
{
    public function getSourceData($source)
    {
        if (is_array($source)) {
            return $source;
        }

        switch (get_class($source)) {
            case 'wajox\yii2base\models\TrafficStream':
                $data = $this->getTrafficStreamData($source);
                break;
            case 'wajox\yii2base\models\TrafficSource':
                $data = $this->getTrafficSourceData($source);
                break;
            case 'wajox\yii2base\models\User':
                $data = $this->getUserData($source);
                break;
            case 'wajox\yii2base\models\Partner':
                $data = $this->getUserData($source->user);
                break;
            case 'wajox\yii2base\models\TrafficManager':
                $data = $this->getUserData($source->user);
                break;
            case 'wajox\yii2base\services\web\HttpReferer':
                $data = $this->getRefererData($source);
                break;
        }

        return $data;
    }

    protected function getTrafficStreamData($stream)
    {
        $title = $stream->description;
        $id = $streem->id;

        return [
            'title' => $title,
            'where' => ['traffic_stream_id' => $sid],
        ];
    }

    protected function getTrafficSourceData($source)
    {
        $title = $source->title;
        $ids = [0];
        foreach ($source->streams as $stream) {
            $ids[] = $stream->id;
        }

        return [
            'title' => $title,
            'where' => ['traffic_stream_id' => $ids],
        ];
    }

    protected function getUserData($user)
    {
        $title = $user->name;
        $id = $user->id;

        return [
            'title' => $title,
            'where' => ['referal_user_id' => $id],
        ];
    }

    protected function getRefererData($referer)
    {
        return [
            'title' => $referer['title'],
            'where' => ['referr_type_id' => $referer['type_id']],
        ];
    }
}
