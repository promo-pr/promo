<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $settings \app\modules\admin\models\Config */

$this->title = 'Основные настройки сайта';
?>

<h2><?= Html::encode($this->title) ?></h2>

<?php $form = ActiveForm::begin(['id' => 'form-config']); ?>

<?php foreach ($settings as $key => $setting) {
echo $form->field($setting, "[$key]value")->label($setting->label);
} ?>

<div class="form-group">
    <?= Html::submitButton('<i class="material-icons">done</i> Сохранить', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
