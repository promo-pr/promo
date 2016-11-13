<?php

use yii\helpers\Html;
use app\modules\admin\rbac\Rbac as AdminRbac;

/* @var $this yii\web\View */
/* @var $model app\modules\slider\models\backend\Slider */

?>

<?php $this->beginBlock('title');
echo Yii::$app->user->can(AdminRbac::PERMISSION_ADMIN_PANEL) ?
    Html::a('<i class="material-icons">mode_edit</i>', ['/admin/sliders/default/update', 'id' => $model->id]) :
    false;
echo Html::encode($model->title);
$this->endBlock(); ?>

<div class="container">
    <div class="field-body">
        <?= $model->body ?>
    </div>

</div>
