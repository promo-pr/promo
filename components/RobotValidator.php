<?php
namespace app\components;

use yii\validators\Validator;

class RobotValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if ($model->$attribute != '') {
            $this->addError($model, $attribute, 'К счастью, мы работаем только с людьми, а Вы - робот!.');
        }
    }
}