<?php

use yii\helpers\Html;
use app\modules\admin\rbac\Rbac as AdminRbac;

/* @var $this yii\web\View */
/* @var $model app\modules\page\models\backend\Page */

?>

<?php $this->beginBlock('title');
echo Yii::$app->user->can(AdminRbac::PERMISSION_ADMIN_PANEL) ?
    Html::a('<i class="material-icons">mode_edit</i>', ['/admin/pages/default/update', 'id' => $model->id]) :
    false;
echo Html::encode($model->title);
$this->endBlock(); ?>

<div class="container">
    <?= \app\widgets\map\Map::widget(['height' => 400]) ?>
    <div class="field-body">
        <?= $model->body ?>
    </div>

</div>
