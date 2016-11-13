<?php

namespace app\modules\file;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use app\modules\file\models\Files;

class FilesBehavior extends Behavior
{

    /**
     * To use FileBehavior, insert the following code to your ActiveRecord class:
     * use app\modules\file\FilesBehavior;
     * function behaviors()
     * {
     *     return [
     *         [
     *             'class' => FilesBehavior::className(),
     *             'attribute' => 'file', //default
     *         ],
     *     ];
     * }
     * in View
     *     $files = $model->getAttachFiles('file');
     *
     *     <? foreach ($files as $file) {echo Html::a($file->name, $file->uri);} ?>
     *     <?= Html::img($image->uri, ['alt'=>$image->name]) ?>
     * 
     */

    public $attribute = 'file';

    public $model_name;

    public $model_id;

    public function __destruct()
    {
        //Files::fileModelCancel();
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function afterInsert()
    {
        $this->fileUpload();
    }

    public function afterUpdate()
    {
        $this->fileUpload();
    }

    public function afterDelete ()
    {
        $this->fileToken();
        $files = Files::findAll([
            'model_name' => $this->model_name,
            'model_id' => $this->model_id
        ]);
        foreach ($files as $file) {
            $file->delete();
        }
    }

    /**
     * @param $attribute
     * @return mixed
     */
    public function getAttachFiles ($attribute)
    {
        $this->fileToken();
        $files = Files::findAll([
            'model_name' => $this->model_name,
            'model_id' => $this->model_id,
            'attribute' => $attribute
        ]);
        return $files;
    }

    /**
     * @return int|bool
     */
    protected function fileUpload ()
    {
        $this->fileToken();
        $files = UploadedFile::getInstancesByName( $this->model_name.'['.$this->attribute.']' );
        if ( count($files) ) {
            foreach ($files as $file) {
                $saveFile = new Files();
                $saveFile->uploadFile($this->model_name, $this->model_id, $this->attribute, $file);
            }
        }
    }

    private function fileToken ()
    {
        $this->model_name = substr(strrchr( get_class($this->owner) , '\\' ), 1 );
        $pk = reset($this->owner->primaryKey());
        $this->model_id = $this->owner->{$pk};
    }

}