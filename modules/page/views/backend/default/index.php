<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\page\models\backend\Page;
use app\widgets\grid\SetColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\page\models\backend\search\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="pull-left">
        <?= Html::a('<i class="material-icons">add</i> Добавить страницу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php Pjax::begin(['enablePushState' => false]); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'contentOptions' => [
                    'class' => 'check-column',
                ],
            ],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    /** @var \app\modules\page\models\backend\Page $model */
                    return Html::a(Html::encode($model->title), ['/page/node/view', 'slug' => $model->slug]);
                }
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'datetime',
                'contentOptions' => [
                    'class' => 'at-column',
                ],
            ],
            [
                'class' => SetColumn::className(),
                'filter' => Page::getStatusesArray(),
                'attribute' => 'status',
                'name' => 'statusName',
                'cssCLasses' => [
                    Page::STATUS_ACTIVE => 'success',
                    Page::STATUS_WAIT => 'warning',
                ],
                'contentOptions' => [
                    'class' => 'status-column',
                ],
            ],
            [
                'class' => 'app\widgets\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        /** @var \app\modules\page\models\backend\Page $model */
                        return Html::a('<i class="material-icons">visibility</i>', ['/page/node/view', 'slug' => $model->slug]);
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
