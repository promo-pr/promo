<?php

namespace app\modules\main\controllers;

use app\modules\main\models\form\ContactForm;
use app\modules\main\models\form\CallForm;
use app\modules\admin\models\Map;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;

class ContactController extends Controller
{
    public function actionIndex()
    {
        $model = new ContactForm();
        if ($user = Yii::$app->user->identity) {
            /** @var \app\modules\user\models\User $user */
            //$model->name = $user->username;
            $model->email = $user->email;
        }
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

    public function actionAjax($form)
    {
        switch($form)
        {
            case 'call';
                $model = new CallForm();
                if (Yii::$app->request->isAjax) {
                    if ( $model->load(Yii::$app->request->post()) && $model->sendAjaxForm(Yii::$app->params['adminEmail']) ) {
                        $message = '<div><div class="alert alert-success">Ваше сообщение отправлено.</div></div>'; // TODO: Refactor
                        return $message;
                    } else {
                        return $this->renderPartial('call', [
                            'model' => $model,
                            'form' => $form,
                        ]);
                    }
                } else {
                    if ($model->load(Yii::$app->request->post()) && $model->sendAjaxForm(Yii::$app->params['adminEmail'])) {
                        Yii::$app->session->setFlash('contactFormSubmitted');
                        return $this->refresh();
                    } else {
                        return $this->render('call', [
                            'model' => $model,
                            'form' => $form,
                        ]);
                    }
                }
                break;
            case 'map';
                if (Yii::$app->request->isPost) {
                    $geoObject = Map::getPoints();
                    header('Content-Type: application/json');
                    return json_encode($geoObject);
                } else {
                    return $this->render('map');
                }
                break;
            default;
                throw new HttpException(404 , 'Страница не найдена' );
                break;
        }
    }
}
