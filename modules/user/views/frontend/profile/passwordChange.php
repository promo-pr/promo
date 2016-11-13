<?php

use yii\bootstrap\ActiveForm;
use app\modules\user\Module;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \app\modules\user\models\frontend\form\PasswordChangeForm */

$this->title = 'Смена пароля';
$this->params['breadcrumbs'][] = ['label' => 'Профиль пользователя', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('title');
echo Html::encode($this->title);
$this->endBlock(); ?>

<div class="container">
    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'currentPassword')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'newPasswordRepeat')->passwordInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton(Module::t('module', 'BUTTON_SAVE'), ['class' => 'btn btn-primary', 'name' => 'change-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

