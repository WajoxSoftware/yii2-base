<?php
namespace wajox\yii2base\services\web;

use wajox\yii2base\components\base\Object;

class HttpReferer extends Object
{
    const REFERER_TYPE_DIRECT = 100;
    const REFERER_TYPE_GOOGLE_SEARCH = 101;
    const REFERER_TYPE_YANDEX_SEARCH = 102;
    const REFERER_TYPE_YAHOO_SEARCH = 103;

    public $uri;
    public $typeId;
    public $searchQuery;

    public function __construct($uri)
    {
        $this->setUri($uri);
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getTypeId()
    {
        return $this->typeId;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
        $this->computeTypeId();

        return $this;
    }

    public function getSearchQuery()
    {
        return $this->searchQuery();
    }

    protected function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    protected function setSearchQuery($searchQuery)
    {
        $this->searchQuery = $searchQuery;

        return $this;
    }

    protected function computeTypeId()
    {
        $typeId = self::REFERER_TYPE_DIRECT;

        $this->setTypeId($typeId);

        $urlParts = parse_url($this->uri);

        if (!isset($urlParts['host'])) {
            return;
        }

        $host = $urlParts['host'];
        $queryParams = [];

        if (isset($urlParts['query'])) {
            $query = parse_str($urlParts['query'], $queryParams);
        }

        foreach (self::getTypeIdList() as $typeId => $params) {
            if (!is_array($params)) {
                continue;
            }

            if (strpos($host, $params['pattern']) == false) {
                continue;
            }

            $qparam = $params['param'];
            $typeId = $id;
            $searchQuery = isset($queryParams[$qparam]) ? $queryParams[$qparam] : null;

            $this->setTypeId($typeId)->setSearchQuery($searchQuery);

            return;
        }
    }

    public static function getTypeIdList()
    {
        return [
              self::REFERER_TYPE_DIRECT => 'Direct',
            self::REFERER_TYPE_GOOGLE_SEARCH => ['title' => 'Google', 'pattern' => 'google.', 'param' => 'q='],
            self::REFERER_TYPE_YANDEX_SEARCH => ['title' => 'Yandex', 'pattern' => 'search.yahoo.com', 'param' => 'p='],
            self::REFERER_TYPE_YAHOO_SEARCH => ['title' => 'Yahoo!', 'pattern' => 'yandex.ru', 'param' => 'text='],
        ];
    }
}
