<?php
namespace wajox\yii2base\modules\webinar\services;

use yii\web\Request;
use wajox\yii2base\components\base\Object;
use wajox\yii2base\modules\webinar\models\Webinar;
use wajox\yii2base\modules\webinar\models\WebinarViewer;
use wajox\yii2base\modules\webinar\events\WebinarEvent;

class WebinarManager extends Object
{
    const WEBINAR_STATUS_STARTED = 'started';
    const WEBINAR_STATUS_ADVERT = 'advert';
    const WEBINAR_STATUS_FINISHED = 'finished';

    public function startView(Webinar $webinar, Request $request, string $email): WebinarViewer
    {
        $viewer = $this->buildViewer($webinar, $email);

        if ($request->isPost
            && $viewer->load($this->getAppRequest()->post())
            && $viewer->save()
        ) {
            $this->setWebinarStarted($webinar);

            $this->triggerEvent(
                $webinar,
                WebinarEvent::EVENT_VIEW_STARTED
            );

            return $viewer;
        }

        return $viewer;
    }

    public function finishView(Webinar $webinar)
    {
        $this->triggerEvent(
            $webinar,
            WebinarEvent::EVENT_VIEW_FINISH
        );
    }

    public function displayAdvert(Webinar $webinar)
    {
        $this->triggerEvent(
            $webinar,
            WebinarEvent::EVENT_ADVERT_DISPLAYED
        );
    }

    public function getCurrentViewer(Webinar $webinar): WebinarViewer
    {
        return $this->findCurrentViewer($webinar);
    }

    protected function buildViewer(Webinar $webinarModel, string $email, array $data = []): WebinarViewer
    {
        $model = $this->createObject(WebinarViewer::className());
        
        if (sizeof($data) > 0) {
            $model->load($data);
        }
        
        $model->guid = $this->getApp()->visitor->getGuid();
        $model->user_id = $this->getAppUser()->id;
        $model->created_at = time();
        $model->webinar_id  = $webinarModel->id;
        $model->email = $email;

        return $model;
    }

    protected function findCurrentViewer(Webinar $webinar): WebinarViewer
    {
        $model = $this
            ->getRepository()
            ->find(WebinarViewer::className())
            ->byWebinarId($webinar->id)
            ->byGuid($this->getApp()->visitor->getGuid())
            ->one();

        if (!$model) {
            throw new \Exception('Viewer not found');
        }

        return $model;
    }

    protected function findViewer(Webinar $webinar, string $email): WebinarViewer
    {
        $model = $this
            ->getRepository()
            ->find(WebinarViewer::className())
            ->byWebinarId($webinar->id)
            ->byEmail($email)
            ->byGuid($this->getApp()->visitor->getGuid())
            ->one();

        if (!$model) {
            throw new \Exception('Viewer not found!');
        }

        return $model;
    }

    public function findModel(int $id): Webinar
    {
        $model = $this
            ->getRepository()
            ->find(Webinar::className())
            ->byId($id)
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function triggerEvent(Webinar $webinar, string $type)
    {
        $event = $this->createObject(WebinarEvent::className());
        $event->webinar = $webinar;
        $this
            ->getApp()
            ->eventsManager
            ->trigger(
                Webinar::className(),
                $type,
                $event
            );
    }

    public function updateWebinarStatus(Webinar $webinar)
    {
        ;
    }

    public function getWebinarStatus(Webinar $webinar)
    {
        return $this
            ->getAppSession()
            ->get('webinar-' . $webinar->id);
    }

    public function setWebinarStatus(Webinar $webinar, string $status)
    {
        $this
            ->getAppSession()
            ->set('webinar-' . $webinar->id, $status);

        return $this;
    }

    public function isWebinarStarted(Webinar $webinar)
    {
        return $this->getWebinarStatus($webinar) == self::WEBINAR_STATUS_STARTED;
    }

    public function isWebinarAdvertDisplayed(Webinar $webinar)
    {
        return $this->getWebinarStatus($webinar) == self::WEBINAR_STATUS_ADVERT;
    }

    public function isWebinarFinished(Webinar $webinar)
    {
        return $this->getWebinarStatus($webinar) == self::WEBINAR_STATUS_FINISHED;
    }

    public function setWebinarStarted(Webinar $webinar)
    {
        $webinar->views_count++;
        $webinar->save();

        return $this->setWebinarStatus($webinar, self::WEBINAR_STATUS_STARTED);
    }

    public function setWebinarAdvertDisplayed(Webinar $webinar)
    {
        return $this->setWebinarStatus($webinar, self::WEBINAR_STATUS_ADVERT);
    }

    public function setWebinarFinished(Webinar $webinar)
    {
        return $this->setWebinarStatus($webinar, self::WEBINAR_STATUS_FINISHED);
    }

    public function getViewersCount(Webinar $webinar): int
    {
        $params = $this->getViewersCountParams($webinar);

        if (sizeof($params) == 0) {
            return 0;
        }

        $minP = $params[0] / 100.0;
        $maxP = $params[1] / 100.0;
        $sizeP = $maxP - $minP;
        $step = $params[2];

        if (isset($params[3])) {
            $posP = $params[3];
        } else {
            $completedP = $webinar->currentTime / $webinar->duration;
            $k = $completedP / $step;
            $posP = $minP + $sizeP * sin(deg2rad(($k == 0 ? 1 : -1) * 90)) / 2;
        }

        $stepP = (time() % 11 - 5) * 0.2;
        $stepSizeP = sin(deg2rad(90 * $stepP));
        $stepSize = $stepSizeP * $step;
        $currentP = $sizeP * $posP;
        $resultP = $minP + $currentP + $currentP * $stepSize;

        $countF = $webinar->max_viewers_count * $resultP;

        return intval($countF);
    }

    public function getViewersCountParams(Webinar $webinar): array
    {
        if (!$webinar->isStarted) {
            $timeLeft = abs($webinar->currentTime);

            if ($timeLeft > 1800) {
                $minP = 1;
                $maxP = 3;
                $step = 0.2;
                $posP = rand(1, 100) / 100;

                return [$minP, $maxP, $step, $posP];
            }

            if ($timeLeft < 1800 && $timeLeft > 1200) {
                $minP = 3;
                $maxP = 15;
                $step = 0.1;
                $posP = 1800 / (1800 - $timeLeft);
                
                return [$minP, $maxP, $step, $posP];
            }

            if ($timeLeft < 1200 && $timeLeft > 600) {
                $minP = 15;
                $maxP = 30;
                $step = 0.1;
                $posP = 1200 / (1200 - $timeLeft);
                
                return [$minP, $maxP, $step, $posP];
            }

            if ($timeLeft < 600) {
                $minP = 30;
                $maxP = 90;
                $step = 0.2;
                $posP = 600 / (600 - $timeLeft);
                
                return [$minP, $maxP, $step, $posP];
            }
        }

        if ($webinar->isActive) {
            $timeLeft = $webinar->currentTime;
            $minP = 90;
            $maxP = 100;
            $step = 0.2;
            
            return [$minP, $maxP, $step];
        }

        if ($webinar->isFinished) {
            $timeLeft = $webinar->currentTime - $webinar->duration;

            if ($timeLeft < 1800 && $timeLeft > 1200) {
                $maxP = 1;
                $minP = 3;
                $step = 0.2;
                $posP = 1 - 1800 / (1800 - $timeLeft);
                
                return [$minP, $maxP, $step, $posP];
            }

            if ($timeLeft < 1200 && $timeLeft > 600) {
                $maxP = 3;
                $minP = 10;
                $step = 0.2;
                $posP = 1 - 1200 / (1200 - $timeLeft);
                
                return [$minP, $maxP, $step, $posP];
            }

            if ($timeLeft > 300 && $timeLeft < 600) {
                $maxP = 10;
                $minP = 20;
                $step = 0.2;
                $posP = 1 - 600 / (600 - $timeLeft);
                
                return [$minP, $maxP, $step, $posP];
            }

            if ($timeLeft > 120 && $timeLeft < 300) {
                $maxP = 20;
                $minP = 35;
                $step = 0.2;
                $posP = 1 - 200 / (200 - $timeLeft);
                
                return [$minP, $maxP, $step, $posP];
            }

            if ($timeLeft < 120) {
                $maxP = 35;
                $minP = 100;
                $step = 0.2;
                $posP = 1 - 120 / (120 - $timeLeft);
                
                return [$minP, $maxP, $step, $posP];
            }
        }

        return [];
    }
}
