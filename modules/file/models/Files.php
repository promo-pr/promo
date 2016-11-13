<?php

namespace app\modules\file\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Inflector;
use yii\imagine\Image;
use Imagine\Image\Box;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use app\modules\slider\models\backend\SliderItem;

/**
 * @property integer $fid
 * @property string $model_name
 * @property integer $model_id
 * @property string $attribute
 * @property string $name
 * @property string $uri
 * @property string $mime
 * @property integer $size
 * @property integer $created_at
 * @property integer $status
 * @property string $thumb
 * @property string $icon
 */
class Files extends ActiveRecord
{
    public $maxWidth = 1200;

    public $quality = 80;

    public $allowed_type = ['image', 'application', 'video', 'audio'];

    public $allowed_mime = ['jpeg', 'png', 'tiff', 'gif', 'pjpeg', 'webp'];

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    public static function tableName()
    {
        return 'files';
    }

    public function rules()
    {
        return [
            [['model_id', 'size', 'created_at', 'status'], 'integer'],
            [['name'], 'required'],
            [['model_name', 'attribute', 'name', 'uri', 'mime'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'fid' => 'File ID',
            'model_name' => 'Model ID',
            'model_id' => 'Node ID',
            'attribute' => 'File attribute',
            'name' => 'Имя файла',
            'uri' => 'URI',
            'mime' => 'Тип файла',
            'size' => 'Размер',
            'created_at' => 'Создан',
            'status' => 'Статус',
        ];
    }

    /**
     * @param string $model_name
     * @param integer $model_id
     * @param string $attribute
     * @param object $file
     * @return mixed
     */
    public function uploadFile ($model_name, $model_id, $attribute, $file = NULL )
    {
        if ( !isset($file) ) {
            $file = UploadedFile::getInstanceByName( $attribute );
        }
        list($type, $mime) = explode("/", $file->type);
        if ( $file->error == 0 && in_array($type, $this->allowed_type, true) ) {
            $this->mime = $file->type;
            $this->model_name = $model_name;
            $this->model_id = $model_id;
            $this->attribute = strstr($attribute, '-', true);
            if (!$this->attribute) {
                $this->attribute = $attribute;
            }
            $this->name = $file->name;
            $this->size = $file->size;
            $year = date('Y', time());
            $month = date('m', time());
            $public = Yii::getAlias('@webroot');
            $directory = '/upload/' . $this->attribute . '/' . $year . '/' . $month . '/';

            if (!file_exists($public . $directory)) {
                FileHelper::createDirectory($public . $directory, 0777, true);
            }

            $filename = Inflector::slug($file->baseName);
            $this->uri = $directory . $filename . '.' . $file->extension;
            $destination = $public . $this->uri;

            if (file_exists($destination)) { // Unique file name
                $counter = 0;
                do {
                    $this->uri = $directory . $filename . '_' . $counter++ . '.' . $file->extension;
                    $destination = $public . $this->uri;
                } while (file_exists($destination));

            }
            if ( in_array($mime, $this->allowed_mime, true) ) {
                $image = Image::getImagine()->open($file->tempName);
                Image::autorotate($image);
                $image
                    ->thumbnail(new Box($this->maxWidth, $this->maxWidth))
                    ->save($destination , ['quality' => $this->quality]);
            } else {
                $file->saveAs($destination);
            }
            $this->save();
            return $this;
        } else {
            return false;
        }

    }
    /**
     * @param integer $width
     * @param integer $height
     * @return string $src
     */
    public function getThumb ($width=150, $height=150)
    {
        $public = Yii::getAlias('@webroot');
        $src = '/cache/' . $width . '_' . $height . $this->uri;
        $path = $public . $src;
            if ( !file_exists($path) ) {
                $dir = pathinfo($path, PATHINFO_DIRNAME);
                if ( !file_exists( $dir ) ) {
                    FileHelper::createDirectory($dir, 0755, true);
                }
                if ( $width && $height ) {
                    $image = Image::thumbnail($public . $this->uri, $width, $height);
                } else {
                    $image = Image::getImagine()->open($public . $this->uri);
                    $box = $image->getSize();
                    if ( $height == 0 ) {
                        $box = $box->widen($width);
                    } else {
                        $box = $box->heighten($height);
                    }
                    $image = $image->thumbnail($box);
                }
                $image->save($path);
            }
        return $src;
    }

    /**
     * @return string $src
     */
    public function getIcon()
    {
        $mime = stristr($this->mime, '/',true);
        if ( $mime == 'image' ) {
            $src = $this->thumb;
        } else {
            $src = '/static/icon/file.png';
        }
        return $src;
    }

    public function beforeDelete()
    {
        $public = Yii::getAlias('@webroot');
        if ( file_exists( $public . $this->uri )) {
            unlink( $public . $this->uri );
        }
        $this->clearCache();
        return parent::beforeDelete();
    }

    public function clearCache()
    {
        $public = Yii::getAlias('@webroot');
        $cacheFiles = FileHelper::findFiles( $public . '/cache' );
        foreach ($cacheFiles as $cacheFile) {
            if ( stripos($cacheFile, FileHelper::normalizePath($this->uri)) ) {
                unlink($cacheFile);
            }
        }
    }

    public function getItem()
    {
        return $this->hasOne(SliderItem::className(), ['fid' => 'fid']);
    }

}
