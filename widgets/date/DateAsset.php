<?php

namespace app\widgets\date;

use yii\web\AssetBundle;

class DateAsset extends AssetBundle
{
	public $sourcePath = '@vendor/bower/air-datepicker/dist';

    public $css = [
        'css/datepicker.min.css'
    ];

	public $js = [
	    'js/datepicker.min.js'
	];

	public $depends = [
		'yii\web\JqueryAsset'
	];
}
