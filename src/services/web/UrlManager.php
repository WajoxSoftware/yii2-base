<?php
namespace wajox\yii2base\services\web;

class UrlManager extends \yii\web\UrlManager
{
    const SUFFIX_QUERY_PARAM = 'suffix';

    public $suffixes = [];

    private $_baseUrl;
    private $_scriptUrl;
    private $_hostInfo;
    private $_ruleCache;

    public function parseRequest($request)
    {
        if ($this->enablePrettyUrl) {
            $pathInfo = $request->getPathInfo();

            /* @var $rule UrlRule */
            foreach ($this->rules as $rule) {
                if (($result = $rule->parseRequest($this, $request)) !== false) {
                    return $result;
                }
            }
            if ($this->enableStrictParsing) {
                return false;
            }
            \Yii::trace('No matching URL rules. Using default URL parsing logic.', __METHOD__);
            // Ensure, that $pathInfo does not end with more than one slash.
            if (strlen($pathInfo) > 1 && substr_compare($pathInfo, '//', -2, 2) === 0) {
                return false;
            }
            $suffixes = (array) $this->suffixes;
            $foundSuffix = null;

            if (sizeof($suffixes) > 0 && $pathInfo !== '') {
                $found = false;
                foreach ($suffixes as $suffix) {
                    $n = strlen($suffix);
                    if (substr_compare($pathInfo, $suffix, -$n, $n) === 0) {
                        $pathInfo = substr($pathInfo, 0, -$n);
                        $foundSuffix = $suffix;
                        $found = true;
                        break;
                    }
                }
            }

            $params = [];

            if ($foundSuffix) {
                $params[self::SUFFIX_QUERY_PARAM] = $foundSuffix;
            }

            return [$pathInfo, $params];
        } else {
            \Yii::trace('Pretty URL not enabled. Using default URL parsing logic.', __METHOD__);
            $route = $request->getQueryParam($this->routeParam, '');
            if (is_array($route)) {
                $route = '';
            }

            return [(string) $route, []];
        }
    }

    public function createUrl($params)
    {
        $params = (array) $params;
        $anchor = isset($params['#']) ? '#'.$params['#'] : '';
        unset($params['#'], $params[$this->routeParam]);
        $route = trim($params[0], '/');
        unset($params[0]);
        $baseUrl = $this->showScriptName || !$this->enablePrettyUrl ? $this->getScriptUrl() : $this->getBaseUrl();
        if ($this->enablePrettyUrl) {
            $cacheKey = $route.'?';
            foreach ($params as $key => $value) {
                if ($value !== null) {
                    $cacheKey .= $key.'&';
                }
            }
            /* @var $rule UrlRule */
            $url = false;
            if (isset($this->_ruleCache[$cacheKey])) {
                foreach ($this->_ruleCache[$cacheKey] as $rule) {
                    if (($url = $rule->createUrl($this, $route, $params)) !== false) {
                        break;
                    }
                }
            } else {
                $this->_ruleCache[$cacheKey] = [];
            }
            if ($url === false) {
                $cacheable = true;
                foreach ($this->rules as $rule) {
                    if (!empty($rule->defaults) && $rule->mode !== UrlRule::PARSING_ONLY) {
                        // if there is a rule with default values involved, the matching result may not be cached
                        $cacheable = false;
                    }
                    if (($url = $rule->createUrl($this, $route, $params)) !== false) {
                        if ($cacheable) {
                            $this->_ruleCache[$cacheKey][] = $rule;
                        }
                        break;
                    }
                }
            }
            if ($url !== false) {
                if (strpos($url, '://') !== false) {
                    if ($baseUrl !== '' && ($pos = strpos($url, '/', 8)) !== false) {
                        return substr($url, 0, $pos).$baseUrl.substr($url, $pos).$anchor;
                    } else {
                        return $url.$baseUrl.$anchor;
                    }
                } else {
                    return "$baseUrl/{$url}{$anchor}";
                }
            }

            $suffix = '';

            if (sizeof($this->suffixes) > 0) {
                if (isset($params['suffix']) && in_array($params['suffix'], $this->suffixes)) {
                    $suffix = $params['suffix'];
                    unset($params['suffix']);
                }
            }

            $route .= $suffix;

            if (!empty($params) && ($query = http_build_query($params)) !== '') {
                $route .= '?'.$query;
            }

            return "$baseUrl/{$route}{$anchor}";
        } else {
            $url = "$baseUrl?{$this->routeParam}=".urlencode($route);
            if (!empty($params) && ($query = http_build_query($params)) !== '') {
                $url .= '&'.$query;
            }

            return $url.$anchor;
        }
    }
}
