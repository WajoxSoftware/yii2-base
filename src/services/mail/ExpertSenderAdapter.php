<?php
namespace wajox\yii2base\services\mail;

use LinguaLeo\ExpertSender\ExpertSender;
use LinguaLeo\ExpertSender\Request\AddUserToList;
use LinguaLeo\ExpertSender\Entities\Receiver;
use LinguaLeo\ExpertSender\Entities\Snippet;

class ExpertSenderAdapter extends SenderAdapterAbstract
{
    public $from = null;
    public $endpointUrl = null;
    public $apiKey = null;
    public $transactional_id = null;
    public $base_list_id = null;
    private $apiSender = null;

    public function __construct($params = [])
    {
        $this->from = $params['from'];
        $this->endpointUrl = $params['endpoint_url'];
        $this->apiKey = $params['api_key'];
        $this->transactional_id = $params['transactional_id'];
        $this->base_list_id = $params['base_list_id'];
        $this->apiSender = new ExpertSender($this->endpointUrl, $this->apiKey);
    }

    public function sendTransactional($to, $subject, $content_text, $content_html)
    {
        $this->addSubscriber($to, $to);

        $snippets = [];
        $snippets[] = new Snippet('subject', $subject);
        $snippets[] = new Snippet('content_text', $content_text, true);
        $snippets[] = new Snippet('content_html', $content_html, true);
        $receiver = new Receiver($to);

        return $this->apiSender->sendTransactional($this->transactional_id, $receiver, $snippets);
    }

    public function send($to, $subject, $template, $data = [], $options = [])
    {
        $content_text = $this->render($template, $data, false);//'<![CDATA[' . $this->render($template, $data, true) . ']]>';
        $content_html = $this->render($template, $data, true);//'<![CDATA[' . $this->render($template, $data, true) . ']]>';
        $apiResult = $this->sendTransactional($to, $subject, $content_text, $content_html);

        return $apiResult->isOk();
    }

    public function addSubscriber($email, $name)
    {
        $data = [
          'list_id' => $this->base_list_id,
          'email' => $email,
          'name' => $name,
        ];

        return $this->addUserToList($data);
    }

    public function getLists()
    {
        return [];
    }

    public function createList($title)
    {
        return;
    }

    public function deleteUserFromList($email, $listId)
    {
        $apiResult = $this->apiSender->deleteUser($email, $listId);

        return $apiResult->isOk();
    }

    public function addUserToList($data)
    {
        $request = new AddUserToList();
        $request->setListId($data['list_id'])
            ->setEmail($data['email'])
            ->setName($data['name'])
            ->freeze();

        $apiResult = $this->apiSender->addUserToList($request);

        return $apiResult->isOk();
    }
}
