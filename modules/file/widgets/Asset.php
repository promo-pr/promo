<?php

namespace app\modules\file\widgets;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
	public $sourcePath = '@app/modules/file/widgets/assets';

	/**
	 * @inheritdoc
	 */
	public $css = [
        'css/cropper.min.css',
	    'css/file-input.css'
	];

	/**
	 * @inheritdoc
	 */
	public $js = [
        'js/cropper.min.js',
	    'js/file-input.js'
	];

	/**
	 * @inheritdoc
	 */
	public $depends = [
		'yii\web\JqueryAsset'
	];
}
