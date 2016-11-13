<?php

namespace app\modules\slider\controllers\frontend;

use Yii;
use yii\web\Controller;
use app\modules\slider\models\backend\Slider;
use yii\web\NotFoundHttpException;

class NodeController extends Controller
{
    public function actionView($slug)
    {
        $model = $this->findModelBySlug($slug);
        
        $this->actionParams = [
            'node' => $model->id,
        ];

        return $this->render('view', [
            'model' => $model
        ]);
    }

    protected function findModelBySlug($slug)
    {
        if (($model = Slider::findOne(['name' => $slug])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException();
        }
    }

}
