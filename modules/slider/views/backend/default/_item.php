<?php

/* @var $this yii\web\View */
/* @var $item app\modules\slider\models\backend\SliderItem */

?>

<div class="dynamic-form-item">
    <input type="hidden" class="slider-item-id" name = "SliderItem[<?= $i ?>][id]" value="<?= $item->id; ?>">
    <div class="form-group field-slider-item-title">
        <label class="control-label"><i class="material-icons">work</i> Название вложения</label>
        <input type="text" class="slider-item-title form-control" name="SliderItem[<?= $i ?>][title]" value="<?= $item->title; ?>" maxlength="255">
        <div class="help-block"></div>
    </div>
    <div class="form-group field-slider-action">
        <div class="btn btn-default sort-item"><i class="material-icons">swap_vert</i></div>
        <div class="btn btn-danger remove-item"><i class="material-icons">delete_forever</i></div>
        <div class="btn btn-primary add-item"><i class="material-icons">add</i></div>
    </div>
    <div class="form-group field-slider-item-file">
        <div class="file-preview" <?= isset($item->files->icon) ? "style='background-image: url({$item->files->icon}); border-style: solid'"  : false; ?> ></div>
        <label class="btn btn-default btn-file"><i class="material-icons">attach_file</i> Файл ...
            <input id="slide-<?= $i ?>" type="file" class="slider-item-file hidden" name="slide-<?= $i ?>">
        </label>
    </div>
    <div class="form-group field-slider-item-body">
        <textarea class="slider-item-body form-control" name="SliderItem[<?= $i ?>][body]" rows="5"><?= $item->body; ?></textarea>
    </div>
</div>