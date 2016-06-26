<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "mainmenu".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $number
 */
class Mainmenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mainmenu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['title'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 200],
            [['number'], 'integer', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'url' => 'Url',
            'number' => 'Number',
        ];
    }
}
