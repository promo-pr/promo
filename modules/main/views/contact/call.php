<?php

use yii\helpers\Html;
use app\widgets\AjaxForm;

/* @var $this \yii\web\View */
/* @var $form \app\widgets\AjaxForm */
/* @var $model \app\modules\main\models\form\CallForm */

?>



<?php $form = AjaxForm::begin(); ?>

<h3>Заказать обратный звонок</h3>

    <?= $form->field($model, 'name', ['options'=>['class'=>'required-name']]) ?>
    <?= $form->field($model, 'tel')->input('tel') ?>
    <div class="form-group">
        <label style="width: 100%">Удобное для звонка время</label>
        <?= $form->field($model, 'hour', [
            'template' => '{input}'
        ])->dropDownList([
            '08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18'
        ],['prompt'=>'Час']) ?>
        <?= $form->field($model, 'min', [
            'template' => '{input}'
        ])->dropDownList([
            '00'=>'00','15'=>'15','30'=>'30','45'=>'45'
        ],['prompt'=>'Мин']) ?>
        <?= Html::submitButton('Заказать', ['class' => 'btn btn-success btn-33', 'name' => 'contact-button']) ?>
    </div>

<?php AjaxForm::end(); ?>

