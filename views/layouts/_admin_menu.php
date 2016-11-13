<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AdminMenuAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AdminMenuAsset::register($this);
?>
<?php
NavBar::begin([
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top admin-menu-wrapper',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-left'],
    'encodeLabels' => false,
    'activateParents' => true,
    'items' => array_filter([
        ['label' => '<i class="material-icons">home</i>', 'url' => Yii::$app->homeUrl],
        ['label' => '<i class="material-icons">settings</i>', 'url' => ['/admin/default/index']],
        ['label' => 'Содержимое', 'items' => [
            ['label' => 'Страницы' . Html::a('<i class="material-icons">add_circle_outline</i>', ['/admin/pages/default/create']), 'url' => ['/admin/pages/default/index']],
            ['label' => 'Новости' . Html::a('<i class="material-icons">add_circle_outline</i>', ['/admin/posts/default/create']), 'url' => ['/admin/posts/default/index']],
            Yii::$app->user->can('permAdminRoot')?
                ['label' => 'Слайдеры' . Html::a('<i class="material-icons">add_circle_outline</i>', ['/admin/sliders/default/create']), 'url' => ['/admin/sliders/default/index']] : false,
        ]],
    ]),
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'encodeLabels' => false,
    'activateParents' => true,
    'items' => array_filter([
        ['label' => '<i class="material-icons">build</i>', 'items' => [
            ['label' => '<i class="material-icons">cached</i> Обновить sitemap', 'url' => ['/admin/default/sitemap'], 'linkOptions' => ['data-method' => 'post']],
            ['label' => '<i class="material-icons">place</i> Схема проезда', 'url' => ['/admin/default/map']],
            Yii::$app->user->can('permAdminRoot')?
                ['label' => '<i class="material-icons">people</i> Пользователи', 'url' => ['/admin/users/default/index']] : false,
        ]],
        ['label' => '<i class="material-icons">power_settings_new</i>', 'url' => ['/user/default/logout'], 'linkOptions' => ['data-method' => 'post']],
    ]),
]);
NavBar::end();
?>


