<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\slider\models\backend\Slider */

$this->title = 'Создание';
$this->params['breadcrumbs'][] = ['label' => 'Слайдеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelSlider' => $modelSlider,
        'modelSliderItem' => $modelSliderItem,
    ]) ?>


