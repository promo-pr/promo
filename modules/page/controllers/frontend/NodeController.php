<?php

namespace app\modules\page\controllers\frontend;

use Yii;
use yii\web\Controller;
use app\modules\page\models\backend\Page;
use yii\web\NotFoundHttpException;

class NodeController extends Controller
{
    public function actionView($slug)
    {
        $model = $this->findModelBySlug($slug);
        
        $this->actionParams = [
            'node' => $model->id,
        ];
        $model->seotitle ? Yii::$app->view->title = $model->seotitle : Yii::$app->view->title = $model->title;
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $model->keywords,
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->description,
        ]);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    protected function findModelBySlug($slug)
    {
        if (($model = Page::findOne(['slug' => $slug])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException();
        }
    }

}
