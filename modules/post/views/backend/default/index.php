<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\post\models\backend\Post;
use app\widgets\grid\SetColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\post\models\backend\search\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="pull-left">
        <?= Html::a('<i class="material-icons">add</i> Добавить новость', ['create'], ['class' => 'btn btn-success']) ?>
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
                    /** @var \app\modules\post\models\backend\Post $model */
                    return Html::a(Html::encode($model->title), ['/post/node/view', 'slug' => $model->slug]);
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
                'filter' => Post::getStatusesArray(),
                'attribute' => 'status',
                'name' => 'statusName',
                'cssCLasses' => [
                    Post::STATUS_ACTIVE => 'success',
                    Post::STATUS_WAIT => 'warning',
                ],
                'contentOptions' => [
                    'class' => 'status-column',
                ],
            ],
            [
                'class' => 'app\widgets\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        /** @var \app\modules\post\models\backend\Post $model */
                        return Html::a('<i class="material-icons">visibility</i>', ['/post/node/view', 'slug' => $model->slug]);
                    },
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
