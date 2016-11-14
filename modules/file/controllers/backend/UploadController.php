<?php

namespace app\modules\file\controllers\backend;

use Yii;
use app\modules\file\models\Files;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UploadController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'file' => ['POST'],
                    'image' => ['POST'],
                    'crop' => ['POST'],
                ],
            ],
        ];
    }


    public function actionFile()
    {
        $file = new Files();
        $file = $file->uploadFile('redactor', 0, 'file');
        if ( $file ) {
            $result =[
                'filelink' => $file->uri,
                'filename' => $file->name
            ];
        } else {
            $result =[
                'error' => 'Данный тип файла не поддерживается'
            ];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    public function actionImage()
    {
        $file = new Files();
        $file = $file->uploadFile('redactor', 0, 'file');
        if ( $file ) {
            $result =[
                'filelink' => $file->uri,
            ];
        } else {
            $result =[
                'error' => 'Данный тип файла не поддерживается'
            ];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    public function actionCrop($fid)
    {
        if ($file = Files::findOne($fid)) {
            $path = Yii::getAlias('@webroot').$file->uri;
            $path = FileHelper::normalizePath($path);
            unlink($path);
            if (move_uploaded_file($_FILES['Crop']['tmp_name'], $path)) {
                $file->clearCache();
                return true;
            } else {
                return false;
            }
        } else {
            throw new NotFoundHttpException();
        }
    }

    /**
     * @param integer $fid
     * @throws
     * @return int|mixed
     */
    public function actionDelete($fid)
    {
        if ($file = Files::findOne($fid)) {
            return $file->delete();
        } else {
            throw new NotFoundHttpException();
        }

    }

}
