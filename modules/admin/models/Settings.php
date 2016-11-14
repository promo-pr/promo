<?php

namespace app\modules\admin\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "map".
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property string $label
 */
class Settings extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value', 'label'], 'string'],
            ['key', 'unique', 'targetAttribute' => ['key'], 'message' => 'Такой ключ уже существует!'],
            [['key', 'value', 'label'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Ключ',
            'value' => 'Значение',
            'label' => 'Название',
        ];
    }

}
