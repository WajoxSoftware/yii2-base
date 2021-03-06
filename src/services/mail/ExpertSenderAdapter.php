<?php
namespace wajox\yii2base\services\mail;

use PicodiLab\Expertsender\ExpertSenderApi;
use PicodiLab\Expertsender\Mapper\Subscriber;

class ExpertSenderAdapter extends SenderAdapterAbstract
{
    const OUTPUT_FORMAT = 'ARRAY';

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
        $this->apiSender = new ExpertSenderApi($this->apiKey, $this->endpointUrl);
    }

    public function sendTransactional(
        $to,
        $subject,
        $content_text,
        $content_html
    ) {
        $this->addSubscriber($to, $to);

        $params = [
            'subject' => $subject,
            'content_text' => $content_text,
            'content_html' => $content_html,
        ];

        return $this->apiSender
            ->Messages()
            ->sendTransactinalMessage(
                $to,
                $params,
                $this->transactional_id
            ) !== false;
    }

    public function send($to, $subject, $template, $data = [], $options = [])
    {
        $content_text = $this->render($template, $data, false);//'<![CDATA[' . $this->render($template, $data, true) . ']]>';
        $content_html = $this->render($template, $data, true);//'<![CDATA[' . $this->render($template, $data, true) . ']]>';
        return $this->sendTransactional($to, $subject, $content_text, $content_html);
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
        return $this->apiSender
            ->Lists()
            ->setOutputFormat(self::OUTPUT_FORMAT)
            ->get();
    }

    public function createList($title)
    {
        return $this->apiSender
            ->Lists()
            ->create($title);
    }

    public function deleteUserFromList($email, $listId)
    {
        $this->apiSender
            ->Subscribers()
            ->deleteSubscriber($email, $listId);
    }

    public function getSubscriber($email)
    {
        return $this->apiSender
            ->Subscribers()
            ->setOutputFormat(self::OUTPUT_FORMAT)
            ->get($email);
    }

    public function addUserToList($data)
    {
        $names = explode(' ', $data['name']);

        $firstName = isset($names[0]) ? $names[0] : '';
        $lastName = isset($names[1]) ? $names[1] : '';

        $subscriber = new Subscriber(
            $data['email'],
            [
                'firstname' => $firstName,
                'lastname' => $lastName,
            ]
        );

        return $this
            ->apiSender
            ->Subscribers()
            ->add($subscriber, $data['list_id'], ['Force' => true]);
    }
}
