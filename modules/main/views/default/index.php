<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>

<?php $this->beginBlock('title');
echo Html::encode($this->title);
$this->endBlock(); ?>


<div class="container">



    <?= \app\modules\slider\widgets\Slider::widget([
        'name' => 'front',
        'width' => 1200,
        'height' => 400,
        'dots' => true
    ]) ?>


    <?= \yii\widgets\ListView::widget([
        'dataProvider' => $dataPages,
        'itemView' => '_post',
        'layout' => "{items}\n{pager}", //"{summary}\n{items}\n{pager}"
        'options' => [
            'class' => 'image-gallery',
        ]
    ]); ?>



    <?= Html::a('Схема проезда', ['/main/contact/ajax', 'form' => 'map'], ['class' => 'map-popup']) . '<br>' ?>

    <?= Html::a('Оценка-ТЛ', ['/main/contact/ajax', 'form' => 'call'], ['class' => 'ajax-popup']) . '<br>' ?>

</div>










