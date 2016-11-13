<?php

namespace app\modules\main\models\form;

use Yii;
use yii\base\Model;
use app\components\RobotValidator;
use app\components\TelefonValidator;

class CallForm extends Model
{
    public $name;
    public $tel;
    public $hour;
    public $min;
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['tel', 'required'],
            ['name', RobotValidator::className()],
            ['tel', TelefonValidator::className()],
            [['hour','min'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'tel' => 'Номер телефона',
            'hour' => 'Часы',
            'min' => 'Минуты',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function sendAjaxForm($email)
    {
        if ($this->validate()) {
            $body = $this->tel.' - '.$this->hour.':'.$this->min;
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setSubject(Yii::$app->name)
                ->setTextBody($body)
                ->send();

            return true;
        } else {
            return false;
        }
    }
}
