<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\slider\models\backend\Slider */

$this->title = 'Редактирование: ' . $modelSlider->title;
$this->params['breadcrumbs'][] = ['label' => 'Слайдеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelSlider->title, 'url' => ['/slider/node/view', 'slug' => $modelSlider->name]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'modelSlider' => $modelSlider,
        'modelSliderItem' => $modelSliderItem,
    ]) ?>


