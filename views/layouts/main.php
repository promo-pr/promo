<?php

use app\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\SiteAsset;


/* @var $this \yii\web\View */
/* @var $content string */

SiteAsset::register($this);
?>
<?php $this->beginContent('@app/views/layouts/layout.php'); ?>

<header id="Header">
    <div class="header-top">

    </div>
    <div class="header-nav">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-default',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'encodeLabels' => false,
            'activateParents' => true,
            'items' => array_filter([
                ['label' => 'Главная', 'url' => ['/main/default/index']],
                ['label' => 'Контакты', 'url' => ['/main/contact/index']],
                Yii::$app->user->isGuest ?
                    ['label' => 'Регистрация', 'url' => ['/user/default/signup']] :
                    false,
                Yii::$app->user->isGuest ?
                    ['label' => 'Вход',
                        'url' => ['/user/default/login-popup'],
                        'linkOptions' => ['class'=>'ajax-popup']] :
                    false,
                !Yii::$app->user->isGuest ?
                    ['label' => 'Профиль', 'items' => [
                        ['label' => 'Просмотр профиля', 'url' => ['/user/profile/index']],
                        ['label' => 'Выход',
                            'url' => ['/user/default/logout'],
                            'linkOptions' => ['data-method' => 'post']]
                    ]] :
                    false,
            ]),
        ]);
        NavBar::end();
        ?>
    </div>
    <div class="header-title">
        <div class="container">
            <?= isset($this->blocks['title']) ? "<h1>" . $this->blocks['title'] . "</h1>" : false ?>
        </div>
    </div>
</header>

<section id="Main">
    <?= $content ?>
</section>

<footer id="Footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::$app->name ?></p>
        <p class="pull-right"><?= date('Y') ?></p>
    </div>
</footer>

<div class="alert-container container">
    <?= Alert::widget() ?>
</div>

<?php $this->endContent(); ?>
