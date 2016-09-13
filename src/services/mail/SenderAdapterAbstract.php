<?php
namespace wajox\yii2base\services\mail;

use wajox\yii2base\components\base\Component;

abstract class SenderAdapterAbstract extends Component
{
    public $layout_html = '@app/mail/layouts/html';
    public $layout_text = '@app/mail/layouts/text';

    abstract public function send($to, $subject, $template, $data = [], $options = []);

    abstract public function addSubscriber($email, $name);

    abstract public function addUserToList($data);

    abstract public function deleteUserFromList($email, $listId);

    public function render($view, $params = [], $html = true)
    {
        $viewFile = '@app/mail/'.$view.($html == true ? '_html' : '_text');
        $content = $this->getApp()->getView()->render($viewFile, $params, $this);

        return $this->renderContent($content, $html);
    }

    public function renderContent($content, $html = true)
    {
        $layout = $html == true ? $this->layout_html : $this->layout_text;

        return $this->getApp()->getView()->render($layout, ['content' => $content], $this);
    }
}
