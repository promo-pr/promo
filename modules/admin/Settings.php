<?php

namespace app\modules\admin;

use Yii;
use yii\base\BootstrapInterface;

class Settings implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $settings = $app->db->createCommand('SELECT * FROM settings')
            ->queryAll();

        foreach ($settings as $key => $val) {
            Yii::$app->params['settings'][$val['key']] = $val['value'];
        }
    }
}