<?php

use app\widgets\Alert;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

/** @var \yii\web\Controller $context */
AdminAsset::register($this);
$context = $this->context;

if (isset($this->params['breadcrumbs'])) {
    $panelBreadcrumbs = [['label' => 'Панель управления', 'url' => ['/admin/default/index']]];
    $breadcrumbs = $this->params['breadcrumbs'];
} else {
    $panelBreadcrumbs = ['Панель управления'];
    $breadcrumbs = [];
}
?>
<?php $this->beginContent('@app/views/layouts/layout.php'); ?>

    <section id="Main">
        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => ArrayHelper::merge($panelBreadcrumbs, $breadcrumbs),
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </section>

    <footer id="Footer">
        <div class="container">
            <p class="pull-left">&copy; <?= Html::a('Фабрика сайтов', '//promo-pr.ru', ['target'=>'_blank']) ?></p>
            <p class="pull-right"><?= date('Y') ?></p>
        </div>
    </footer>

<?php $this->endContent(); ?>