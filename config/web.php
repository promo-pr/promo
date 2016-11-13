<?php

$config = [
    'id' => 'app',
    'language'=>'ru-RU',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'layout' => '@app/views/layouts/admin',
            'modules' => [
                'users' => [
                    'class' => 'app\modules\user\Module',
                    'controllerNamespace' => 'app\modules\user\controllers\backend',
                    'viewPath' => '@app/modules/user/views/backend',
                ],
                'files' => [
                    'class' => 'app\modules\file\Module',
                    'controllerNamespace' => 'app\modules\file\controllers\backend',
                    'viewPath' => '@app/modules/files/views/backend',
                ],
                'pages' => [
                    'class' => 'app\modules\page\Module',
                   'controllerNamespace' => 'app\modules\page\controllers\backend',
                    'viewPath' => '@app/modules/page/views/backend',
                ],
                'posts' => [
                    'class' => 'app\modules\post\Module',
                    'controllerNamespace' => 'app\modules\post\controllers\backend',
                    'viewPath' => '@app/modules/post/views/backend',
                ],
                'sliders' => [
                    'class' => 'app\modules\slider\Module',
                    'controllerNamespace' => 'app\modules\slider\controllers\backend',
                    'viewPath' => '@app/modules/slider/views/backend',
                ],
            ]
        ],
        'file' => [
            'class' => 'app\modules\file\Module',
            'controllerNamespace' => 'app\modules\files\controllers\frontend',
        ],
        'main' => [
            'class' => 'app\modules\main\Module',
        ],
        'page' => [
            'class' => 'app\modules\page\Module',
            'controllerNamespace' => 'app\modules\page\controllers\frontend',
            'viewPath' => '@app/modules/page/views/frontend',
        ],
        'post' => [
            'class' => 'app\modules\post\Module',
            'controllerNamespace' => 'app\modules\post\controllers\frontend',
            'viewPath' => '@app/modules/post/views/frontend',
        ],
        'user' => [
            'class' => 'app\modules\user\Module',
            'controllerNamespace' => 'app\modules\user\controllers\frontend',
            'viewPath' => '@app/modules/user/views/frontend',
        ],
        'slider' => [
            'class' => 'app\modules\slider\Module',
            'controllerNamespace' => 'app\modules\slider\controllers\frontend',
            'viewPath' => '@app/modules/slider/views/frontend',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'app\components\UserIdentity',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/default/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'main/default/error',
        ],
        'request' => [
            'cookieValidationKey' => '',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
