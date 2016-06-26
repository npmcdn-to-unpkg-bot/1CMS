<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property string $text
 * @property integer $post_id
 * @property integer $user_id
 * @property boolean $status
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'post_id', 'user_id'], 'required'],
            [['post_id', 'user_id'], 'integer'],
            [['text'], 'string', 'max' => 400],
            [['status'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
            'status'=> 'Status',
        ];
    }
}
