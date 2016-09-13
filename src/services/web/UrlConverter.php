<?php
namespace wajox\yii2base\services\web;

use yii\helpers\Url;
use wajox\yii2base\components\base\Object;

class UrlConverter extends Object
{
    const INTERNAL_SCHEMA = 'app';
    const INTERNAL_PATH_HOST = 'path.rq';
    const INTERNAL_CLASS_HOST = 'class.rq';

    public function isInternal($url)
    {
        $urlParts = parse_url($url);

        return isset($urlParts['scheme']) && $urlParts['scheme'] == self::INTERNAL_SCHEMA;
    }

    public function buildPath($path = '/', $params = [])
    {
        $query = http_build_query($params);

        return self::INTERNAL_SCHEMA
            . '://' . self::INTERNAL_PATH_HOST
            . '/' . $path
            . '/?' . $query;
    }

    public function buildClass($classOrObject, $params = ['id'])
    {
        $attrs = [];
        if (is_object($classOrObject)) {
            foreach ($params as $attrName) {
                $attrs[$attrName] = $classOrObject->$attrName;
            }
        }

        $query = http_build_query($attrs);
        $path = $this->class2path($classOrObject);

        return self::INTERNAL_SCHEMA
            . '://' . self::INTERNAL_CLASS_HOST
            . '/' . $path
            . '/?' . $query;
    }

    public function extract($url)
    {
        if (!$this->isInternal($url)) {
            return $url;
        }

        $urlParts = parse_url($url);

        if ($urlParts['host'] == self::INTERNAL_PATH_HOST) {
            return $this->extractPath($urlParts);
        }

        if ($urlParts['host'] == self::INTERNAL_CLASS_HOST) {
            return $this->extractClass($urlParts);
        }

        throw new \Exception('Unknown host type');
    }

    protected function extractPath($urlParts)
    {
        $path = $urlParts['path'];
        parse_str($urlParts['query'], $params);

        $routeParams = $params;
        $routeParams[0] = $path;

        return Url::toRoute($routeParams, true);
    }

    protected function extractClass($urlParts)
    {
        $className = $this->path2class($urlParts['path']);
        parse_str($urlParts['query'], $params);

        $model = $className::find()->where($params)->one();

        return ['class' => $className, 'params' => $params, 'model' => $model];
    }

    protected function path2class($path)
    {
        $path = str_replace('/', '\\', $path);
        $length = strlen($path);
        $className = substr($path, 0, $length - 1);

        if (!class_exists($className)) {
            throw new \Exception('Class not found');
        }

        return $className;
    }

    protected function class2path($classOrObject)
    {
        if (is_object($classOrObject)) {
            $className = get_class($classOrObject);
        } else {
            $className = $classOrObject;
        }

        $path = str_replace('\\', '/', $className);

        return $path;
    }
}
