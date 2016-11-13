<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets\map;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MapInputAsset extends AssetBundle
{
    public $sourcePath = '@app/widgets/map/assets';
    public $js = [
        '//api-maps.yandex.ru/2.1/?lang=ru_RU',
        'js/map-input.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\widgets\ActiveFormAsset',
    ];
}
