<?php

use yii\helpers\Html;
use app\widgets\BodyClass;
use app\modules\admin\rbac\Rbac as AdminRbac;

/* @var $this \yii\web\View */
/* @var $content string */

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<?php BodyClass::begin()?>
    <?php $this->beginBody() ?>
        <?= $content ?>

<?= Yii::$app->user->can(AdminRbac::PERMISSION_ADMIN_PANEL) ?
    $this->render('_admin_menu')
    :false; ?>

    <?php $this->endBody() ?>
<?php BodyClass::end()?>
</html>
<?php $this->endPage() ?>
