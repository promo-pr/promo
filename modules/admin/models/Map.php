<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "map".
 *
 * @property integer $id
 * @property string $title
 * @property string $preset
 * @property string $body
 * @property string $point
 * @property integer $zoom
 */
class Map extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body'], 'string'],
            [['zoom'], 'integer'],
            [['title', 'preset', 'point'], 'string', 'max' => 255],
            [['title', 'preset', 'point','zoom'], 'trimAttribute'],
            ['point', 'unique', 'targetAttribute' => ['point'], 'message' => 'Это место занято. Переместите метку!'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Надпись в метке',
            'preset' => 'Тип метки',
            'body' => 'Содержимое балуна',
            'point' => 'Координаты',
            'zoom' => 'Масштаб',
        ];
    }

    public function beforeValidate()
    {
        $coor = explode( ',', $this->point );
        $this->point = round( $coor[0], 5).','.round( $coor[1], 5);
        return parent::beforeValidate();
    }

    public function trimAttribute($attribute, $params)
    {
        $this->$attribute = trim($this->$attribute, " \t\n\r\0\x0B\'\"");
    }

    public static function getPoints()
    {
        $points = parent::find()->all();
        if (count($points)>0) {
            $geoObject = ['type' => 'FeatureCollection'];
            foreach ($points as $point) {
                $geoObject['features'][] = [
                    'type' => 'Feature',
                    'id' => $point->id,
                    'geometry' =>[
                        'type' => 'Point',
                        'coordinates' => explode( ',', $point->point ),
                    ],
                    'properties' => [
                        'balloonContent' => $point->body,
                        'iconContent' => $point->title,
                    ],
                    'options' => [
                        'preset' => $point->preset,
                    ],
                ];
            }
        } else {
            $geoObject = false;
        }
        return $geoObject;
    }

}
