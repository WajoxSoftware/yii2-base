<?php
namespace wajox\yii2base\modules\payment\models\form;

use wajox\yii2base\components\base\Model;
use wajox\yii2base\module\payment\services\BillMailer;

class BillQuestionForm extends Model
{
    public $message;

    protected $bill;

    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['message'], 'filter', 'filter' => 'strip_tags'],
            [['message'], 'filter', 'filter' => 'trim'],
            [['message'], 'required'],
        ];
    }

    public function process($request)
    {
        return ($request->isPost
            && $this->load($request->post())
            && $this->validate()
            && $this->send()
        );
    }

    public function setBill($bill)
    {
        $this->bill = $bill;

        return $this;
    }

    protected function getBill()
    {
        return $this->bill;
    }

    protected function send()
    {
        $billMailer = $this->craeteObject(BillMailer::className(), [$this->getBill]);

        $billMailer->sendQuestion($this->message);

        return true;
    }

    public function attributeLabels()
    {
        return [
            'message' => \Yii::t('app/attributes', 'Body'),
        ];
    }
}
