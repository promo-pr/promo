<?php

namespace app\modules\slider\controllers\backend;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\file\models\Files;
use app\modules\slider\models\backend\Slider;
use app\modules\slider\models\backend\SliderItem;
use app\modules\slider\models\backend\search\SliderSearch;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new SliderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $this->layout = '@app/views/layouts/admin';
        $modelSlider = new Slider();
        $post = Yii::$app->request->post();
        if ($modelSlider->load($post) && $modelSlider->save()) {
            $transaction = Yii::$app->db->beginTransaction();
            try  {
                $items = $post['SliderItem'];
                $i = 0;
                foreach ($items as $item) {
                    $err = $_FILES['slide-' . $i]['error'];
                    if ( $err == 0 || $item['title'] !== '' || $item['body'] !== '' ) {
                        $sliderItem = new SliderItem();
                        $sliderItem->title = $item['title'];
                        $sliderItem->body = $item['body'];
                        $sliderItem->slider_id = $modelSlider->id;
                        if ( $err == 0 ) {
                            $saveFile = new Files();
                            $fid = $saveFile->uploadFile('SliderItem', $modelSlider->id, 'slide-' . $i );
                            $sliderItem->fid = $fid->fid;
                        } else {
                            $sliderItem->fid = null;
                        }
                        $sliderItem->sort_order = $i;
                        $sliderItem->save();
                    }
                    $i++;
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
            return $this->redirect(['/slider/node/view', 'slug' => $modelSlider->name]);
        } else {
            $modelSliderItem[0] = new SliderItem();
            return $this->render('create', [
                'modelSlider' => $modelSlider,
                'modelSliderItem' => $modelSliderItem,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $this->layout = '@app/views/layouts/admin';
        $modelSlider = $this->findSlider($id);
        $post = Yii::$app->request->post();
        if ($modelSlider->load($post) && $modelSlider->save()) {
            $transaction = Yii::$app->db->beginTransaction();
            try  {
                $i = 0;
                foreach ($post['SliderItem'] as $item) {
                    $err = $_FILES['slide-' . $i]['error'];
                    if ( $item['id'] > 0 || $err == 0 || $item['title'] !== '' || $item['body'] !== '' ) {
                        if ($item['id'] > 0) {
                            $sliderItem = SliderItem::findOne($item['id']);
                        } else {
                            $sliderItem = new SliderItem();
                        }
                        $sliderItem->title = $item['title'];
                        $sliderItem->body = $item['body'];
                        $sliderItem->slider_id = $modelSlider->id;
                        $sliderItem->sort_order = $i;
                        if ($_FILES['slide-' . $i]['error'] == 0) {
                            if ($sliderItem->fid > 0) {
                                Files::findOne(['fid' => $sliderItem->fid])->delete();
                            }
                            $saveFile = new Files();
                            $fid = $saveFile->uploadFile('SliderItem', $modelSlider->id, 'slide-' . $i);
                            $sliderItem->fid = $fid->fid;
                        }
                        $sliderItem->save();
                    }
                    $i++;
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
            return $this->redirect(['/slider/node/view', 'slug' => $modelSlider->name]);
        } else {
            $items = $modelSlider->items;
            if ( !count($items) ) {
                $items[0] = new SliderItem();
            }
            return $this->render('update', [
                'modelSlider' => $modelSlider,
                'modelSliderItem' => $items,
            ]);
        }
    }

    public function actionDelete($id)
    {
        Slider::findOne($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionSliderItemDelete($id)
    {
        return SliderItem::findOne($id)->delete();
    }

    protected function findSlider($id)
    {
        if (($model = Slider::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
