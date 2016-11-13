<?php

use yii\bootstrap\ActiveForm;
use app\modules\user\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\modules\user\models\frontend\form\ProfileUpdateForm */

$this->title = 'Редактирование';
$this->params['breadcrumbs'][] = ['label' => 'Профиль пользователя', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('title');
echo Html::encode($this->title);
$this->endBlock(); ?>

<div class="container">
    <div class="user-form">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
