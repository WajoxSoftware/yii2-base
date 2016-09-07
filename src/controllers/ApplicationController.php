<?php

namespace wajox\yii2base\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ApplicationController extends Controller
{
    const REQUEST_TYPE_QUERY_PARAM = 'suffix';
    const REQUEST_TYPE_JS = '.js';
    const REQUEST_TYPE_JSON = '.json';
    const REQUEST_TYPE_XML = '.xml';
    const REQUEST_TYPE_HTML = '.html';
    const REQUEST_TYPE_TEXT = '.txt';

    protected $responseFormats = [];

    public function accountSettingsRedirect()
    {
        return $this->redirect(['/account/settings']);
    }

    public function getRequestType()
    {
        return \Yii::$app->request->getQueryParam(
            self::REQUEST_TYPE_QUERY_PARAM,
            self::REQUEST_TYPE_HTML
        );
    }

    public function isJsRequest()
    {
        return $this->getRequestType() == self::REQUEST_TYPE_JS;
    }

    public function isJsonRequest()
    {
        return $this->getRequestType() == self::REQUEST_TYPE_JSON;
    }

    public function isXmlRequest()
    {
        return $this->getRequestType() == self::REQUEST_TYPE_XML;
    }

    public function isHtmlRequest()
    {
        return $this->getRequestType() == self::REQUEST_TYPE_HTML;
    }

    public function isTextRequest()
    {
        return $this->getRequestType() == self::REQUEST_TYPE_TEXT;
    }

    public function asJson($response)
    {
        $this->responseFormats[self::REQUEST_TYPE_JSON] = $response;

        return $this;
    }

    public function asJs($response)
    {
        $this->responseFormats[self::REQUEST_TYPE_JS] = $response;

        return $this;
    }

    public function asXml($response)
    {
        $this->responseFormats[self::REQUEST_TYPE_XML] = $response;

        return $this;
    }

    public function asHtml($response)
    {
        $this->responseFormats[self::REQUEST_TYPE_HTML] = $response;

        return $this;
    }

    public function asText($response)
    {
        $this->responseFormats[self::REQUEST_TYPE_TEXT] = $response;

        return $this;
    }

    public function renderJs($template, $data = [])
    {
        $this->layout = '@app/views/layouts/js';

        return parent::render($template.'_js', $data);
    }

    public function renderJson($template, $data = [])
    {
        $this->layout = false;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

        return parent::render($template.'_json', $data);
    }

    public function renderXml($template, $data = [])
    {
        $this->layout = false;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;

        return parent::render($template.'_xml', $data);
    }

    public function renderHtml($template, $data = [])
    {
        return parent::render($template, $data);
    }

    public function renderText($template, $data = [])
    {
        $this->layout = false;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;

        return parent::render($template.'_txt', $data);
    }

    public function render($template, $params = [])
    {
        if ($this->isJsRequest()) {
            return $this->renderJs($template, $params);
        }

        if ($this->isJsonRequest()) {
            return $this->renderJson($template, $params);
        }

        if ($this->isXmlRequest()) {
            return $this->renderXml($template, $params);
        }

        if ($this->isTextRequest()) {
            return $this->renderText($template, $params);
        }

        if ($this->isHtmlRequest()) {
            return $this->renderHtml($template, $params);
        }

        throw new NotFoundHttpException();
    }

    public function renderFormat($template)
    {
        $requestType = $this->getRequestType();

        if (!isset($this->responseFormats[$requestType])) {
            throw new NotFoundHttpException();
        }

        $data = $this->responseFormats[$requestType];
        $data = is_array($data) ? $data : $data($this);

        return $this->render($template, $data);
    }

    public function getUser()
    {
        if (\Yii::$app->user->isGuest) {
            return false;
        }

        return \Yii::$app->user->identity;
    }

    public function getListingViewType($listingViewType)
    {
        return \wajox\yii2base\components\helpers\ViewTypesHelper::getViewType($listingViewType);
    }
}
