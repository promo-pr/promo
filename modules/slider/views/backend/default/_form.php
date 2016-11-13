<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use vova07\imperavi\Widget;
use app\modules\slider\Asset;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $modelSlider app\modules\slider\models\backend\Slider */
/* @var $modelSliderItem app\modules\slider\models\backend\SliderItem */
/* @var $item app\modules\slider\models\backend\SliderItem */
/* @var $form yii\widgets\ActiveForm */

Asset::register($this);

?>
<div class="container">
    <?php $form = ActiveForm::begin([
        'options'=>['enctype'=>'multipart/form-data'] // important
    ]); ?>
    <div class="row">
        <div class="col-md-5">
            <?= $form->field($modelSlider, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-5">
            <?= $form->field($modelSlider, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?php $modelSlider->status = $modelSlider->isNewRecord ? 1 : $modelSlider->status; ?>
            <?= $form->field($modelSlider, 'status')->dropDownList([
                '0' => 'Черновик',
                '1' => 'Опубликовано',
            ]) ?>
        </div>
    </div>



    <div class="panel panel-primary gray">
        <div class="panel-body">
            <div id="dynamic-form">

                    <?php foreach($modelSliderItem as $i => $item) { ?>
                        <?= $this->render('_item', [
                            'i' => $i,
                            'item' => $item,
                        ]) ?>
                    <?php } ?>

            </div>
        </div>
    </div>


    <div class="hidden">
        <?= $form->field($modelSlider, 'body')->widget(Widget::className(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 200,
                'toolbarFixedTopOffset' => 28,
                'formatting' => ['blockquote', 'h2', 'h3', 'h4', 'h5'],
                'fileUpload' => Url::to(['/files/upload/file']),
                'imageUpload' => Url::to(['/files/upload/image']),
                'imageFloatMargin' => '15px',
                'plugins' => [
                    'fontcolor',
                    'table',
                    'video',
                    'fullscreen'
                ]
            ]
        ]); ?>
    </div>
    <?= Html::submitButton('<i class="material-icons">check</i> Сохранить', ['class' => 'btn btn-success']) ?>
    <?= $modelSlider->isNewRecord ? false : Html::a('<i class="material-icons">delete</i> Удалить', ['delete', 'id'=>$modelSlider->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => "Эта операция не может быть отменена. Продолжить?",
        ]]) ?>
    <?= Html::a('Отмена', Yii::$app->request->referrer, ['class' => 'btn btn-default']) ?>

    <?php ActiveForm::end(); ?>

</div>

