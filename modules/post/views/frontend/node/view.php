<?php

use yii\helpers\Html;
use app\modules\admin\rbac\Rbac as AdminRbac;

/* @var $this yii\web\View */
/* @var $model app\modules\post\models\backend\Post */
/* @var $attach_image */

$images = $model->getAttachFiles('image');
?>

<?php $this->beginBlock('title');
echo Yii::$app->user->can(AdminRbac::PERMISSION_ADMIN_PANEL) ?
    Html::a('<i class="material-icons">mode_edit</i>', ['/admin/posts/default/update', 'id' => $model->id]) :
    false;
echo Html::encode($model->title);
$this->endBlock(); ?>

<div class="container">
    <div class="field-body">
        <?php foreach ($images as $image) {
            echo Html::img($image->thumb, ['alt' => $image->name]);
        } ?>
        <?= $model->body ?>
    </div>
    <div class="flipper row">
        <div class="col-md-6">
            <?= $prev->slug ?
                Html::a('<i class="material-icons">chevron_left</i> ' . $prev->title, ['view', 'slug' => $prev->slug], ['class' => 'prev text-left']) :
                false ?>
        </div>
        <div class="col-md-6">
            <?= $next->slug ?
                Html::a($next->title . '<i class="material-icons">chevron_right</i> ', ['view', 'slug' => $next->slug], ['class' => 'next text-right']) :
                false ?>
        </div>
    </div>
</div>

