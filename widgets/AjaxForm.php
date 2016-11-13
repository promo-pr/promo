<?php

namespace app\widgets;

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

class AjaxForm extends ActiveForm
{
    public $maxWidth = 350;

    public $enableClientScript = false;

    public static $autoIdPrefix = 'Ajax-form-';

    /**
     * in controller app\modules\main\controllers\ContactController
     * public function actionAjax($form) 
     * {
     * case 'call';
     * $model = new CallForm(); / your Model form
     * break;
     * }
     * in view
     * <?= Html::a('Оценка-ТЛ', ['/main/contact/ajax', 'form'=>'call'], ['class'=>'ajax-popup'])?>
     */
    public function init()
    {
        ob_start();
        parent::init();
    }
    
    public function run()
    {
        $this->options['class'] = 'ajax-form';
        parent::run();
        $content = ob_get_clean();
        return Html::tag('div', $content, ['class'=>'ajax-form-wrapper', 'style'=>"max-width:{$this->maxWidth}px"]);
    }
}