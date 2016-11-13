<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\user\Module;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\User */

$this->title = 'Профиль пользователя';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php $this->beginBlock('title');
echo Html::encode($this->title);
$this->endBlock(); ?>

<div class="container">
    <p>
        <?= Html::a('Редактировать', ['update'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Сменить пароль', ['password-change'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email',
        ],
    ]) ?>

</div>