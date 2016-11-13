<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\page\models\backend\Page */

$this->title = 'Создание';
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


