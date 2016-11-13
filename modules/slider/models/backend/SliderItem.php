<?php

namespace app\modules\slider\models\backend;

use app\modules\file\FilesBehavior;
use app\modules\file\models\Files;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "slider_item".
 *
 * @property integer $id
 * @property integer $slider_id
 * @property integer $fid
 * @property string $title
 * @property string $body
 * @property integer $sort_order
 */
class SliderItem extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => FilesBehavior::className(),
                'attribute' => 'image',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slider_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['slider_id', 'fid'], 'integer'],
            [['body'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['title', 'body', 'sort_order'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slider_id' => 'Slider ID',
            'fid' => 'FID',
            'title' => 'Заголовок',
            'body' => 'Описание',
            'sort_order' => 'Вес',
        ];
    }

    public function afterDelete()
    {
        Files::findOne(['fid' => $this->fid])->delete();
        parent::afterDelete();
    }

    public function getSlider()
    {
        return $this->hasOne(Slider::className(), ['id' => 'slider_id']);
    }

    public function getFiles()
    {
        return $this->hasOne(Files::className(), ['fid' => 'fid']);
    }

}
