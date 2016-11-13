<?php

namespace app\modules\post\models\backend;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use app\modules\file\FilesBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property string $slug
 * @property string $seotitle
 * @property string $keywords
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $image
 */
class Post extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 0;

    public $image;
    public $file;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'immutable' => true,
                'ensureUnique' => true,
            ],
            [
                'class' => FilesBehavior::className(),
                'attribute' => 'image',
            ],
            [
                'class' => FilesBehavior::className(),
                'attribute' => 'file',
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['body', 'description'], 'string'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'slug', 'seotitle', 'keywords'], 'string', 'max' => 255],
            [['image'], 'file', 'maxFiles' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'body' => 'Содержимое',
            'slug' => 'ЧПУ / URL',
            'seotitle' => 'SEO Заголовок',
            'keywords' => 'Ключевые слова',
            'description' => 'Описание',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'status' => 'Статус',
            'image' => 'Изображение',
        ];
    }

    public function getPrev ()
    {
        return $this::find()
            ->where(['>', 'updated_at', $this->updated_at])
            ->orderBy('updated_at ASC')
            ->one();
    }

    public function getNext ()
    {
        return $this::find()
            ->where(['<', 'updated_at', $this->updated_at])
            ->orderBy('updated_at DESC')
            ->one();
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_ACTIVE => 'Опубликовано',
            self::STATUS_WAIT => 'Черновик',
        ];
    }
    
}
