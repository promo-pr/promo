<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\admin\models\Map;
use app\modules\page\models\backend\Page;
use app\modules\post\models\backend\Post;
use samdark\sitemap\Sitemap;


class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMap()
    {
        $model = new Map();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('configMapSave');
            return $this->refresh();
        } else {
            return $this->render('map', [
                'model' => $model,
            ]);
        }
    }

    public function actionMapEdit($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['map']);
        } else {
            return $this->render('map', [
                'model' => $model,
            ]);
        }
    }

    public function actionMapDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['map']);
    }

    protected function findModel($id)
    {
        if (($model = Map::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Страница не найдена.');
        }
    }

    public function actionSitemap()
    {
        if (Yii::$app->request->isPost) {

            $sitemap = new Sitemap(Yii::getAlias('@webroot/sitemap.xml'));
            $sitemap->addItem(Url::to(['/main/default/index'], true), time(), Sitemap::WEEKLY, 1);
            $sitemap->addItem(Url::to(['/main/contact/index'], true), time(), Sitemap::MONTHLY, 1);

            $pages = Page::findAll(['status'=>1]);
            foreach ($pages as $page) {
                $sitemap->addItem(Url::to(['/page/node/view','slug'=>$page->slug], true), $page->updated_at, Sitemap::MONTHLY, 1);
            }

            $posts = Post::findAll(['status'=>1]);
            foreach ($posts as $post) {
                $sitemap->addItem(Url::to(['/post/node/view','slug'=>$post->slug], true), $post->updated_at, Sitemap::NEVER, 0.8);
            }

            $sitemap->write();

            Yii::$app->session->setFlash('success', "Файл sitemap.xml успешно обновлен.");

            Yii::$app->request->referrer ? $this->redirect(Yii::$app->request->referrer) : $this->goHome();
            
        } else {
            throw new NotFoundHttpException('Страница не найдена');
        }
    }
    
}
