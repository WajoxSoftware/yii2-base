<?php
namespace wajox\yii2base\services\users;

use wajox\yii2base\components\base\Component;
use wajox\yii2base\services\web\HttpReferer;
use wajox\yii2base\services\web\AddressByIp;
use wajox\yii2base\models\User;
use wajox\yii2base\models\Partner;
use wajox\yii2base\models\TrafficStream;
use wajox\yii2base\models\Log;

class Visitor extends Component
{
    const REFERAL_PARAM = '_r_id';
    const USER_SUB_PARAM = '_s_id';
    const STREAM_PARAM = '_ts_id';
    const CID_PARAM = '_c_id';
    const CID_GET_PARAM = 'c_id';
    const GUID_PARAM = '_guid';
    const OFFER_TYPE_PARAM = '_offType';
    const OFFER_ID_PARAM = '_offId';

    protected $trafficStream = null;
    protected $referal = null;
    protected $ip = null;
    protected $guid = null;
    protected $cookieId = '';
    protected $userAgent = null;
    protected $requestUri = null;
    protected $referer = null;
    protected $cityName = null;
    protected $regionName = null;
    protected $countryName = null;
    protected $offerTypeId = null;
    protected $offerItemId = null;

    public function __construct()
    {
        $this->loadData();
    }

    public function resetGuid()
    {
        $this->setGuid($this->generateGuid());
    }

    public function loadData()
    {
        $this->loadReferal();
        $this->loadTrafficStream();
        $this->loadOffer();
        $this->loadCookieId();
        $this->loadGuid();
        $this->loadIp();
        $this->loadUserAgent();
        $this->loadReferer();
        $this->loadRequest();
    }

    public function assignPartner($user)
    {
        $user->referal_user_id = $this->referalId;
        $user->save();
    }

    public function assignOffer($typeId, $itemId = 0)
    {
        $this->setOfferTypeId($typeId);
        $this->setOfferItemId($itemId);
    }

    public function getOfferTypeId()
    {
        if ($this->offerTypeId == null) {
            return Log::OFFER_TYPE_ID_NONE;
        }

        return $this->offerTypeId;
    }

    public function getOfferItemId()
    {
        if ($this->offerItemId == null) {
            return null;
        }

        return $this->offerItemId;
    }

    public function getReferalId()
    {
        if ($this->referal == null) {
            return null;
        }

        return $this->referal->id;
    }

    public function getTrafficStreamId()
    {
        if ($this->trafficStream == null) {
            return null;
        }

        return $this->trafficStream->id;
    }

    public function getPartnerId()
    {
        if ($this->partner != null) {
            return $this->partner->id;
        }

        return null;
    }

    public function getPartner()
    {
        if ($this->referal) {
            return $this->referal->partner;
        }

        return;
    }

    public function getReferal()
    {
        return $this->referal;
    }

    public function getTrafficStream()
    {
        return $this->trafficStream;
    }

    public function getCookieId()
    {
        return $this->cookieId;
    }

    public function getUserId()
    {
        return $this->getApp()->user->isGuest ? 0 : $this->getApp()->user->id;
    }

    public function getGuid()
    {
        return $this->guid;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getUserAgent()
    {
        return $this->userAgent;
    }

    public function getRefererTypeId()
    {
        return $this->referer->getTypeId();
    }

    public function getRefererUri()
    {
        return  $this->referer->getUri();
    }

    public function getRefererQuery()
    {
        return  $this->referer->getSearchQuery();
    }

    public function getRequestUri()
    {
        return $this->requestUri;
    }

    public function getCountry()
    {
        return $this->countryName;
    }

    public function getRegion()
    {
        return $this->regionName;
    }

    public function getCity()
    {
        return $this->cityName;
    }

    protected function loadDirectPartnerUser()
    {
        $partner = $this
            ->getRepository()
            ->find(Partner::className())
            ->where(['type_id' => Partner::TYPE_ID_DIRECT])
            ->one();

        if ($partner != null) {
            return $partner->user;
        }

        return;
    }

    protected function loadOffer()
    {
        $offerTypeId = intval($this->getParam(self::OFFER_TYPE_PARAM, Log::OFFER_TYPE_ID_NONE));
        $offerItemId = intval($this->getParam(self::OFFER_ID_PARAM, 0));
        /**
         * @todo  fix
         * @deprecated
         */
        /*if ($this->trafficStream != null && $this->trafficStream->good != null) {
            $offerTypeId = Log::OFFER_TYPE_ID_GOOD;
            $offerItemId = $this->trafficStream->good->id;
        }*/

        $this->setOfferTypeId($offerTypeId);
        $this->setOfferItemId($offerItemId);
    }

    protected function setOfferTypeId($typeId)
    {
        $this->offerTypeId = $typeId;

        $this->setParam(self::OFFER_TYPE_PARAM, $typeId);
    }

    protected function setOfferItemId($itemId)
    {
        $this->offerItemId = $itemId;

        $this->setParam(self::OFFER_ID_PARAM, $itemId);
    }

    protected function loadReferalId()
    {
        $referalId = intval($this->getParam(self::REFERAL_PARAM, 0));
        $referalId = $this->trafficStream == null ? $referalId : $this->trafficStream->user_id;

        return $referalId;
    }

    protected function setReferal($user)
    {
        $this->referal = $user;
        $id = $this->referal == null ? null : $this->referal->id;
        $this->getApp()->session[self::REFERAL_PARAM] = $id;
    }

    protected function loadReferal()
    {
        $referalId = $this->loadReferalId();
        $referal = null;
        if ($referalId != null) {
            $referal = $this
                ->getRepository()
                ->find(User::className())
                ->byId((int) $referalId)
                ->one();
        }

        if ($referal == null) {
            $referal = $this->loadDirectPartnerUser();
        }

        $this->setReferal($referal);
    }

    protected function loadTrafficStreamId()
    {
        $streamId = isset($this->getApp()->session[self::STREAM_PARAM]) ? htmlspecialchars($this->getApp()->session[self::STREAM_PARAM]) : null;
        $streamId = isset($_GET[self::STREAM_PARAM]) ? htmlspecialchars($_GET[self::STREAM_PARAM]) : $streamId;

        return $streamId;
    }

    public function setTrafficStream($trafficStream)
    {
        $this->trafficStream = $trafficStream;

        $id = 0;

        if ($this->trafficStream != null) {
            $id = $this->trafficStream->id;
            $this->setReferal($this->trafficStream->user);
        }

        $this->getApp()->session[self::STREAM_PARAM] = $id;
    }

    protected function loadTrafficStream()
    {
        $streamId = $this->loadTrafficStreamId();
        $stream = $this
            ->getRepository()
            ->find(TrafficStream::className())
            ->byId((int) $streamId)
            ->one();

        $this->setTrafficStream($stream);
    }

    protected function setCookieId($cid)
    {
        $this->cookieId = $cid;
        $this->getApp()->session[self::CID_PARAM] = $this->cookieId;
    }

    protected function loadCookieId()
    {
        $cid = '';
        $cid = isset($_GET[self::CID_GET_PARAM]) ? intval($_GET[self::CID_GET_PARAM]) : '';
        $cid = isset($this->getApp()->session[self::CID_PARAM]) ? intval($this->getApp()->session[self::CID_PARAM]) : $cid;

        $this->setCookieId($cid . '');
    }

    protected function generateGuid()
    {
        return md5(uniqid(time(), true));
    }

    protected function setGuid($guid)
    {
        $this->guid = empty($guid) ? $this->generateGuid() : $guid;

        $this->getApp()->session[self::GUID_PARAM] = $this->guid;
    }

    protected function loadGuid()
    {
        $guid = isset($this->getApp()->session[self::GUID_PARAM]) ? $this->getApp()->session[self::GUID_PARAM] : $this->generateGuid();
        $this->setGuid($guid);
    }

    protected function loadIp()
    {
        $this->ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';

        if ($this->ip == '0.0.0.0') {
            return;
        }

        $geo = AddressByIp::get($this->ip);

        if ($geo == null) {
            return;
        }

        $this->countryName = $geo->country;
        $this->regionName = $geo->regionName;
        $this->cityName = $geo->city;
    }

    protected function loadUserAgent()
    {
        $this->userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    }

    protected function loadReferer()
    {
        $uri = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

        $this->referer = $this->createObject(HttpReferer::className(), [$uri]);
    }

    protected function loadRequest()
    {
        $this->requestUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
    }

    public function setRequestUri($uri)
    {
        $this->requestUri = $uri;

        return $this;
    }

    protected function getParam($name, $default = null)
    {
        $param = $default;

        $param = isset($this->getApp()->session[$name]) ? $this->getApp()->session[$name] : $param;
        $param = isset($_GET[$name]) ? $_GET[$name] : $param;

        return $param;
    }

    protected function setParam($name, $value)
    {
        $this->getApp()->session[$name] = $value;
        $_GET[$name] = $value;
    }
}
