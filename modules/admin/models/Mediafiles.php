<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "mediafiles".
 *
 * @property integer $id
 * @property string $title
 * @property string $date
 * @property string $ext
 * @property string $type
 * @property string $murl
 */
class Mediafiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mediafiles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'ext', 'type', 'murl'], 'required'],
            [['title'], 'string'],
            [['date'], 'safe'],
            [['ext'], 'string', 'max' => 5],
            [['type'], 'string', 'max' => 50],
            [['murl'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif, php, js, doc, docx, pdf, mov, avi, mp3'],
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
            'date' => 'Date',
            'ext' => 'Ext',
            'type' => 'Type',
            'murl' => 'Upload file',
        ];
    }
}
