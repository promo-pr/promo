<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Settings;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\modules\admin\models\Map;
use app\modules\page\models\backend\Page;
use app\modules\post\models\backend\Post;
use samdark\sitemap\Sitemap;


class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'flush' => ['POST'],
                    'sitemap' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $settings = Settings::find()->indexBy('key')->all();
        if (Settings::loadMultiple($settings, Yii::$app->request->post()) && Settings::validateMultiple($settings)) {
            foreach ($settings as $setting) {
                $setting->save(false);
            }
            Yii::$app->session->setFlash('success', "Настройки сайта сохранены.");
            return $this->render('index', [
                'settings' => $settings,
            ]);
        }
        return $this->render('index', [
            'settings' => $settings,
        ]);
    }

    public function actionFlush()
    {
        $this->actionSitemap();
        Yii::$app->cache->flush() ?
            Yii::$app->session->setFlash('success', "Все данные на сайте обновлены.") :
            Yii::$app->session->setFlash('danger', "Что-то пошло не так. Попробуйте очистить кэш позднее.");
        Yii::$app->request->referrer ? $this->redirect(Yii::$app->request->referrer) : $this->goHome();
    }

    public function actionMap()
    {
        $model = new Map();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Настройки карты сохранены.");
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
    }
    
}
