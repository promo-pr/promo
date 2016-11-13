<?php
use yii\helpers\Html;



?>


<div class="media">
    <?= empty( $image = $model->getAttachFiles('image',150,150,1) ) ? false : Html::a(Html::img($image->url, [
        'alt'=>$image->filename,
        'width'=>$image->width,
        'height'=>$image->height,
        'class' => 'media-object',
    ]), $image->original, ['class'=>'pull-left media-left image-item']) ?>
    <div class="media-body">
        <h4 class="media-heading"><?= Html::a($model->title, ['/post/node/view', 'slug'=>$model->slug]) ?></h4>
        <?= substr(strip_tags($model->body),0,400) ?>
    </div>
</div>