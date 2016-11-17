<?php

namespace app\widgets\map;

use app\modules\admin\rbac\Rbac;
use Yii;
use yii\helpers\Html;
use yii\base\Widget;
use yii\helpers\Json;

/**
 * Class Map
 * @package app\widgets\map
 * 
 * <?= \app\widgets\map\Map::widget(['height' => 400]) ?>
 */
class Map extends Widget
{
    public $height = 400;

    public $model = '\app\modules\admin\models\Map';

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $rb = Yii::$app->user->can(Rbac::PERMISSION_ADMIN_PANEL);
        $model = new $this->model;
        $points = $model::find()->all();
        if (count($points)>0) {
            $geoObject = ['type' => 'FeatureCollection'];
            $zoom = [];
            foreach ($points as $point) {
                if ($rb) {
                    $delete = '<hr>'
                        . Html::a('<i class="material-icons">create</i> Редактировать', ['/admin/default/map-edit', 'id' =>$point->id])
                        . '&nbsp;&nbsp;&nbsp;'
                        . Html::a('<i class="material-icons">delete</i> Удалить', ['/admin/default/map-delete', 'id' =>$point->id]);
                } else {
                    $delete = '';
                }
                $geoObject['features'][] = [
                    'type' => 'Feature',
                    'id' => $point->id,
                    'geometry' =>[
                        'type' => 'Point',
                        'coordinates' => explode( ',', $point->point ),
                    ],
                    'properties' => [
                        'balloonContent' => $point->body . $delete,
                        'iconContent' => $point->title,
                    ],
                    'options' => [
                        'preset' => $point->preset,
                    ],
                ];
                if ($point->zoom) {
                    $zoom[] = $point->zoom;
                } else {
                    $zoom[] = 14;
                }

            }
        } else {
            $geoObject = false;
            $zoom[0] = 14;
        }
        $geoObject = Json::encode($geoObject);
        $view = $this->view;
        $view->registerJs("var geoObj = {$geoObject}, zoom = {$zoom[0]};", $view::POS_HEAD);
        MapInputAsset::register($view);

        return Html::tag('div', '', ['id' => 'map', 'style' => "height:{$this->height}px"]);
    }
}