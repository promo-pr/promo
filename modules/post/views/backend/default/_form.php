<?php

use yii\helpers\Html;
use app\modules\file\widgets\FileInput;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;
use app\widgets\date\Picker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\post\models\backend\Post */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin([
    'options'=>['enctype'=>'multipart/form-data'] // important
]); ?>
<div class="row">
    <div class="col-xs-9 col-md-10">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-xs-3 col-md-2">
        <?php $model->status = $model->isNewRecord ? 1 : $model->status; ?>
        <?= $form->field($model, 'status')->dropDownList([
            '0' => 'Черновик',
            '1' => 'Опубликовано',
        ]) ?>
    </div>
</div>

<div class="form-group field-post-image">
    <?= $form->field($model, 'image[]')->widget(FileInput::className(), ['multiple'=>true]); ?>
</div>

<div class="form-group field-post-file">
    <?= $form->field($model, 'file[]')->widget(FileInput::className(), ['multiple'=>true]); ?>
</div>

<?= $form->field($model, 'body')->widget(Widget::className(), [
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

<div class="pull-right">
    <a class="btn btn-default" role="button" data-toggle="collapse" href="#collapseSEO" aria-expanded="false" aria-controls="collapseSEO">
        <i class="material-icons">settings</i> Поисковая оптимизация
    </a>
</div>

<div class="collapse" id="collapseSEO">

    <div class="row" style="clear: both">
        <div class="col-sm-<?= $model->isNewRecord ? 6 : 4 ?>">
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-<?= $model->isNewRecord ? 6 : 5 ?>">
            <?= $form->field($model, 'seotitle')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $model->isNewRecord ? false : $form->field($model, 'created_at')->widget(Picker::classname()); ?>
        </div>
    </div>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

</div>

<?= Html::submitButton('<i class="material-icons">check</i> Сохранить', ['class' => 'btn btn-success']) ?>
<?= $model->isNewRecord ? false : Html::a('<i class="material-icons">delete</i> Удалить', ['delete', 'id'=>$model->id], [
    'class' => 'btn btn-danger',
    'data' => [
        'confirm' => "Эта операция не может быть отменена. Продолжить?",
    ]]) ?>
<?= Html::a('Отмена', Yii::$app->request->referrer, ['class' => 'btn btn-default']) ?>



<?php ActiveForm::end(); ?>


