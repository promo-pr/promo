<?php

namespace app\modules\slider;

use yii\web\AssetBundle;

class SortableAsset extends AssetBundle
{
    public $sourcePath = '@app/vendor/bower/html.sortable/dist';
    public $js = [
        'html.sortable.min.js'
    ];
}
