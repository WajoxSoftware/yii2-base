<?php
namespace wajox\yii2base\controllers;

use wajox\yii2base\services\traffic\ClicksManager;

class ClicksController extends Controller
{
    public function actionIndex()
    {
        $this->layout = false;

        return $this->renderJs('index');
    }

    public function actionPixel()
    {
        $this->layout = false;

        $url = isset($_SERVER['HTTP_REFERER']) ?
            $_SERVER['HTTP_REFERER'] : null;

        $this->registerClick($url);

        return;
    }

    public function actionCreate($url)
    {
        $this->layout = false;

        $this->registerClick($url);

        return $this->renderJs('create', [
            'clickUrl' => htmlentities($url),
        ]);
    }

    protected function registerClick($url)
    {
        if ($url) {
            $this
                ->getApp()
                ->visitor
                ->setRequestUri($url);
        }

        $this
            ->getClicksManager()
            ->save();
    }

    protected function getClicksManager()
    {
        return $this->getDependency(ClicksManager::className());
    }
}
