<?php

namespace app\modules\main\controllers;

use app\modules\post\models\backend\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $dataPages = new ActiveDataProvider([
            'query' => Post::find()->where(['status'=>1])->orderBy('updated_at DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', [
            'dataPages' => $dataPages,
        ]);
    }
}
