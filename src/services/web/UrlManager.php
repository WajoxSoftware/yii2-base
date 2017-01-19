<?php
namespace wajox\yii2base\services\web;

class UrlManager extends \codemix\localeurls\UrlManager
{
    const SUFFIX_QUERY_PARAM = 'suffix';

    public $suffixes = [];
    public $languages = [];
    public $enableLocaleUrls = true;
    public $enableDefaultLanguageUrlCode = false;
    public $enableLanguageDetection = true;
    public $enableLanguagePersistence = true;
    public $keepUppercaseLanguageCode = false;
    public $languageSessionKey = '_language';
    public $languageCookieName = '_language';
    public $languageCookieDuration = 2592000;
    public $languageCookieOptions = [];
    public $ignoreLanguageUrlPatterns = [];
    public $enablePrettyUrl = true;
    public $languageParam = 'language';

    protected $_baseUrl;
    protected $_scriptUrl;
    protected $_hostInfo;
    protected $_ruleCache;
    protected $_request;
    protected $_processed = false;
    protected $_defaultLanguage;

    public function init()
    {
        if ($this->enableLocaleUrls
            && $this->languages
            && !$this->enablePrettyUrl
        ) {
            throw new InvalidConfigException('Locale URL support requires enablePrettyUrl to be set to true.');
        }

        $this->_defaultLanguage = \Yii::$app->language;

        parent::init();
    }

    public function getDefaultLanguage()
    {
        return $this->_defaultLanguage;
    }

    public function parseRequest($request)
    {
        if ($this->enableLocaleUrls && $this->languages) {
            $this->parseLocaleRequest($request);
        }

        if ($this->enablePrettyUrl) {
            return $this->parsePrettyRequest($request);
        }

        \Yii::trace('Pretty URL not enabled. Using default URL parsing logic.', __METHOD__);

        $route = $request->getQueryParam($this->routeParam, '');

        if (is_array($route)) {
            $route = '';
        }

        return [(string) $route, []];
    }

    public function createUrl($params)
    {
        $params = (array) $params;
        $anchor = isset($params['#']) ? '#'.$params['#'] : '';
        unset($params['#'], $params[$this->routeParam]);
        $route = trim($params[0], '/');
        unset($params[0]);
        $baseUrl = $this->showScriptName || !$this->enablePrettyUrl ? $this->getScriptUrl() : $this->getBaseUrl();

        if ($this->ignoreLanguageUrlPatterns) {
            foreach ($this->ignoreLanguageUrlPatterns as $pattern => $v) {
                if (preg_match($pattern, $route)) {
                    return $this->createUrlDefault(
                        $route,
                        $baseUrl,
                        $params,
                        $anchor
                    );
                }
            }
        }

        if ($this->enableLocaleUrls
            && $this->languages
        ) {
            return $this->createLanguageUrl(
                $route,
                $baseUrl,
                $params,
                $anchor
            );
        }

        return $this->createUrlDefault(
            $route,
            $baseUrl,
            $params,
            $anchor
        );
    }

    protected function createLanguageUrl(string $route, string $baseUrl, array $params, string $anchor): string
    {
        $addLanguage = false;
        $isLanguageGiven = isset($params[$this->languageParam]);
        $language = $isLanguageGiven ? $params[$this->languageParam] : \Yii::$app->language;
        $isDefaultLanguage = $language===$this->getDefaultLanguage();

        if ($isLanguageGiven) {
            unset($params[$this->languageParam]);
        }

        $url = $this->createUrlDefault(
            $route,
            $baseUrl,
            $params,
            $anchor
        );

        $continue = !empty($language)
            && (
                !$isDefaultLanguage
                || $this->enableDefaultLanguageUrlCode
                ||  $isLanguageGiven
                    && (
                        $this->enableLanguagePersistence
                        || $this->enableLanguageDetection
                    )
            );

        if (!$continue) {
            return $url;
        }

        $key = array_search($language, $this->languages);
        if (is_string($key)) {
            $language = $key;
        }

        if (!$this->keepUppercaseLanguageCode) {
            $language = strtolower($language);
        }
        // Remove any trailing slashes unless one is configured as suffix
        if ($this->suffix !== '/') {
            if (count($params) !== 1) {
                $url = preg_replace('#/\?#', '?', $url);
            } else {
                $url = rtrim($url, '/');
            }
        }

        $needle = $this->showScriptName ? $this->getScriptUrl() : $this->getBaseUrl();
        // Check for server name URL
        if (strpos($url, '://')!==false) {
            if (($pos = strpos($url, '/', 8))!==false || ($pos = strpos($url, '?', 8))!==false) {
                $needle = substr($url, 0, $pos) . $needle;
            } else {
                $needle = $url . $needle;
            }
        }

        $needleLength = strlen($needle);
        return $needleLength ? substr_replace($url, "$needle/$language", 0, $needleLength) : "/$language$url";
    }

    protected function createUrlDefault(string $route, string $baseUrl, array $params, string $anchor): string
    {
        if ($this->enablePrettyUrl) {
            return $this->createPrettyUrl(
                $route,
                $baseUrl,
                $params,
                $anchor
            );
        }

        return $this->createBasicUrl(
            $route,
            $baseUrl,
            $params,
            $anchor
        );
    }

    protected function createBasicUrl(string $route, string $baseUrl, array $params, string $anchor): string
    {
        $url = "$baseUrl?{$this->routeParam}="
            . urlencode($route);

        if (!empty($params)
            && ($query = http_build_query($params)) !== ''
        ) {
            $url .= '&' . $query;
        }

        return $url . $anchor;
    }

    protected function createPrettyUrl(string $route, string $baseUrl, array $params, string $anchor): string
    {
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
    }

    protected function findSuffix($pathInfo)
    {
        $suffixes = (array) $this->suffixes;

        if (sizeof($suffixes) == 0
            || empty($pathInfo)
        ) {
            return;
        }

        foreach ($suffixes as $suffix) {
            $n = strlen($suffix);
            if (substr_compare($pathInfo, $suffix, -$n, $n) === 0) {
                $pathInfo = substr($pathInfo, 0, -$n);
                return $suffix;
            }
        }
    }

    protected function parseLocaleRequest($request)
    {
        $process = true;
        if ($this->ignoreLanguageUrlPatterns) {
            $pathInfo = $request->getPathInfo();
            foreach ($this->ignoreLanguageUrlPatterns as $k => $pattern) {
                if (preg_match($pattern, $pathInfo)) {
                    $process = false;
                }
            }
        }

        if ($process && !$this->_processed) {
            $this->_processed = true;
            $this->processLocaleUrl($request);
        }
    }

    protected function parsePrettyRequest($request)
    {
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

        if (strlen($pathInfo) > 1 && substr_compare($pathInfo, '//', -2, 2) === 0) {
            return false;
        }

        $params = [];
        $suffix = $this->findSuffix($pathInfo);

        if ($foundSuffix) {
            $params[self::SUFFIX_QUERY_PARAM] = $foundSuffix;
        }

        return [$pathInfo, $params];
    }

    protected function processLocaleUrl($request)
    {
        $this->_request = $request;
        $pathInfo = $request->getPathInfo();
        $parts = [];
        foreach ($this->languages as $k => $v) {
            $value = is_string($k) ? $k : $v;
            if (substr($value, -2)==='-*') {
                $lng = substr($value, 0, -2);
                $parts[] = "$lng\-[a-z]{2,3}";
                $parts[] = $lng;
            } else {
                $parts[] = $value;
            }
        }

        $pattern = implode('|', $parts);
        if (preg_match("#^($pattern)\b(/?)#i", $pathInfo, $m)) {
            $request->setPathInfo(mb_substr($pathInfo, mb_strlen($m[1].$m[2])));
            $code = $m[1];
            if (isset($this->languages[$code])) {
                // Replace alias with language code
                $language = $this->languages[$code];
            } else {
                // lowercase language, uppercase country
                list($language, $country) = $this->matchCode($code);
                if ($country!==null) {
                    if ($code==="$language-$country" && !$this->keepUppercaseLanguageCode) {
                        $this->redirectToLanguage(strtolower($code));   // Redirect ll-CC to ll-cc
                    } else {
                        $language = "$language-$country";
                    }
                }
                if ($language===null) {
                    $language = $code;
                }
            }

            \Yii::$app->language = $language;

            if ($this->enableLanguagePersistence) {
                \Yii::$app->session[$this->languageSessionKey] = $language;

                if ($this->languageCookieDuration) {
                    $cookie = new Cookie(array_merge(
                        ['httpOnly' => true],
                        $this->languageCookieOptions,
                        [
                            'name' => $this->languageCookieName,
                            'value' => $language,
                            'expire' => time() + (int) $this->languageCookieDuration,
                        ]
                    ));
                    \Yii::$app->getResponse()->getCookies()->add($cookie);
                }
            }

            // "Reset" case: We called e.g. /fr/demo/page so the persisted language was set back to "fr".
            // Now we can redirect to the URL without language prefix, if default prefixes are disabled.
            if (!$this->enableDefaultLanguageUrlCode
                && $language === $this->_defaultLanguage
            ) {
                $this->redirectToLanguage('');
            }
        } else {
            $language = null;
            if ($this->enableLanguagePersistence) {
                $language = \Yii::$app
                    ->session
                    ->get($this->languageSessionKey);

                if ($language===null) {
                    $language = $request
                        ->getCookies()
                        ->getValue($this->languageCookieName);
                }
            }
            if ($language===null
                && $this->enableLanguageDetection
            ) {
                foreach ($request->getAcceptableLanguages() as $acceptable) {
                    list($language, $country) = $this->matchCode($acceptable);
                    if ($language!==null) {
                        $language = $country===null ? $language : "$language-$country";
                        break;
                    }
                }
            }
            if ($language===null || $language===$this->_defaultLanguage) {
                if (!$this->enableDefaultLanguageUrlCode) {
                    return;
                } else {
                    $language = $this->_defaultLanguage;
                }
            }

            if ($this->matchCode($language)===[null, null]) {
                return;
            }

            $key = array_search($language, $this->languages);
            if ($key && is_string($key)) {
                $language = $key;
            }

            $this->redirectToLanguage($this->keepUppercaseLanguageCode ? $language : strtolower($language));
        }
    }

    protected function matchCode($code)
    {
        $language = $code;
        $country = null;
        $parts = explode('-', $code);
        if (count($parts)===2) {
            $language = $parts[0];
            $country = strtoupper($parts[1]);
        }

        if (in_array($code, $this->languages)) {
            return [$language, $country];
        } elseif (
            $country && in_array("$language-$country", $this->languages) ||
            in_array("$language-*", $this->languages)
        ) {
            return [$language, $country];
        } elseif (in_array($language, $this->languages)) {
            return [$language, null];
        } else {
            return [null, null];
        }
    }

    protected function redirectToLanguage($language)
    {
        $result = parent::parseRequest($this->_request);
        if ($result === false) {
            throw new \yii\web\NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        list($route, $params) = $result;
        if ($language) {
            $params[$this->languageParam] = $language;
        }
        // See Yii Issues #8291 and #9161:
        $params = $params + $this->_request->getQueryParams();
        array_unshift($params, $route);
        $url = $this->createUrl($params);
        // Required to prevent double slashes on generated URLs
        if ($this->suffix==='/' && $route==='') {
            $url = rtrim($url, '/').'/';
        }
        
        \Yii::$app->getResponse()->redirect($url);
        \Yii::$app->end();
    }
}
