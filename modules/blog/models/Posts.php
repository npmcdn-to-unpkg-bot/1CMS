<?php

namespace app\modules\blog\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\BaseStringHelper;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property string $text_preview
 * @property string $img
 * @property string $categories_id
 * @property string $author_id
 * @property string $tags
 * @property string $date_create
 */
class Posts extends \yii\db\ActiveRecord
{
    public $image;
    public $filename;
    public $string;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 150],
            [['tags'], 'string', 'max' => 200],
            [['text_preview'], 'string', 'max' => 250],
            [['categories_id'], 'integer'],
            [['author_id'], 'integer'],
//            [['img'], 'file'],
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
            'text' => 'Text',
            'text_preview' => 'Text Preview',
            'img' => 'Img',
            'categories_id' => 'Categories ID',
            'author_id' => 'Author ID',
            'tags' => 'Tags',
            'date_create' => 'Date Creating'
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->string = substr(uniqid('img'), 0, 12); //imgRandomString
            $this->image = UploadedFile::getInstance($this, 'img');
            $this->filename = 'static/images/' . $this->string . '.' . $this->image->extension;
            $this->image->saveAs($this->filename);
            $this->text_preview = BaseStringHelper::truncate($this->text, 150, '...');
            $this->img = '/' . $this->filename;
        } else {
            $this->image = UploadedFile::getInstance($this, 'img');
            if ($this->image) {
                $this->string = substr(uniqid('img'), 0, 12);
                $this->filename = 'static/image' . $this->string . '.' . $this->image->extension;
                $this->img = '/' . $this->filename;
                $this->image->saveAs(substr($this->img, 1));
            }
        }
        return parent::beforeSave($insert);
    }
}
