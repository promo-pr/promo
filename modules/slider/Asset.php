<?php

namespace app\modules\slider;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $sourcePath = '@app/modules/slider/assets';
    public $css = [
        //'css/slider.css',
    ];
    public $js = [
        'js/slider.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'vova07\imperavi\Asset',
        'app\modules\slider\SortableAsset',
    ];
}
