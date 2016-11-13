<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\slider\models\backend\Slider;
use app\widgets\grid\SetColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\slider\models\backend\search\SliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Слайдеры';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="pull-left">
        <?= Html::a('<i class="material-icons">add</i> Добавить слайдер', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php Pjax::begin(['enablePushState' => false]); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
            ],
            [
                'attribute' => 'name',
            ],
            [
                'class' => SetColumn::className(),
                'filter' => Slider::getStatusesArray(),
                'attribute' => 'status',
                'name' => 'statusName',
                'cssCLasses' => [
                    Slider::STATUS_ACTIVE => 'success',
                    Slider::STATUS_WAIT => 'warning',
                ],
                'contentOptions' => [
                    'class' => 'status-column',
                ],
            ],
            [
                'class' => 'app\widgets\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        /** @var \app\modules\slider\models\backend\Slider $model */
                        return Html::a('<i class="material-icons">visibility</i>', ['/slider/node/view', 'slug' => $model->name]);
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
