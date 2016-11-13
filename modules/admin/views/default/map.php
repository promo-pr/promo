<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \app\modules\user\models\backend\User */

$this->title = 'Схема проезда';
$this->params['breadcrumbs'][] = $this->title;

?>

    <h1><?= Html::encode($this->title) ?></h1>


<?php if (Yii::$app->session->hasFlash('configMapSave')): ?>
    <div class="alert alert-success">
        <?= 'Настройки карты сохранены.'; ?>
    </div>
<?php endif; ?>

<?php $form = ActiveForm::begin(['id' => 'config-map']); ?>

    <div class="form-group">

        <?= $form->field($model, 'point', [
            'template' => '<div class="element-invisible">{input}</div>{error}'
        ])
            ->textInput([
                'data' => [
                    'id' => $model->isNewRecord ? false : $model->id,
                    'error' => $model->errors ? true : false,
                ],
            ]) ?>
        <?= $form->field($model, 'zoom', [
            'template' => '<div class="element-invisible">{input}</div>{error}'
        ])
            ->textInput() ?>

        <?= \app\widgets\map\MapInput::widget(['height' => 400]) ?>
    </div>
    <h3><?= $model->isNewRecord ? Html::button('<i class="material-icons">add_location</i> Добавить объект на карту',[
            'id' => 'addObj',
            'class' => 'btn btn-primary',
            'data' => [
                'toggle'=> 'collapse',
                'target' => '#collapseMap'
            ],
            'aria' => [
                'expanded' => false,
                'controls' => 'collapseMap'
            ]
        ]) : 'Редактирование объекта'; ?></h3>

    <div id="collapseMap" class='collapse <?= !$model->isNewRecord || $model->errors ? 'in' : false; ?>' >
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'preset')->textInput(['maxlength' => true])->label('Вид метки '.Html::a('<i class="material-icons">info_outline</i>', 'https://tech.yandex.ru/maps/doc/jsapi/2.1/ref/reference/option.presetStorage-docpage', ['target'=>'_blank'])) ?>
            </div>
        </div>

        <?= $form->field($model, 'body')->widget(\vova07\imperavi\Widget::className(), [
            'settings' => [
                'lang' => 'ru',
                'minHeight' => 200,
                'toolbarFixedTopOffset' => 28,
                'formatting' => ['blockquote', 'h2', 'h3', 'h4', 'h5'],
                'fileUpload' => Url::to(['/admin/files/upload/file']),
                'imageUpload' => Url::to(['/admin/files/upload/image']),
                'imageFloatMargin' => '15px',
                'plugins' => [
                    'fontcolor',
                    'table',
                    'video',
                    'fullscreen'
                ]
            ]
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton('<i class="material-icons">done</i> Сохранить', ['class' => 'btn btn-success']) ?>
            &nbsp;
            <?= $model->isNewRecord || $model->errors ? false : Html::a('Отмена', Yii::$app->request->referrer, ['class' => 'btn btn-default']) ?>
        </div>

    </div>
<?php ActiveForm::end(); ?>