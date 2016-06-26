<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "widgets".
 *
 * @property integer $id
 * @property string $name
 * @property string $zone
 */
class Widgetus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widgets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'zone'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['zone'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'zone' => 'Zone',
        ];
    }
}
