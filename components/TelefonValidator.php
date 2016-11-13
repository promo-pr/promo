<?php
namespace app\components;

use yii\validators\Validator;

class TelefonValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        $regV = '/^([+]?[0-9\s-\(\)]{3,25})*$/';
        $res = preg_match ($regV, $model->$attribute);
        if ( $res === 0 ) {
            $this->addError($model, $attribute, 'Введите корректный номер телефона.');
        }
    }
}