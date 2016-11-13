<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\modules\user\models\form\LoginForm */

$this->title = 'Вход на сайт';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('title');
echo Html::encode($this->title);
$this->endBlock(); ?>

<div class="container">
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password')->passwordInput()->label('Пароль ' . Html::a('<i class="material-icons">info_outline</i>', ['password-reset-request'])) ?>
    <div class="row text-muted">
        <div class="col-xs-6">
            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>
        </div>
        <div class="col-xs-6">
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</>


