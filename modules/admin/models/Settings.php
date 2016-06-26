<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $theme
 * @property integer $pagination
 * @property string $site_title
 * @property string $site_description
 * @property string $keywords
 * @property string $mail_template
 */
class Settings extends \yii\db\ActiveRecord
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
            [['pagination', 'site_title', 'site_description', 'keywords'], 'required'],
            [['pagination'], 'integer'],
            [['site_title', 'keywords', 'theme'], 'string', 'max' => 50],
            [['site_description'], 'string', 'max' => 200],
            [['mail_template'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'theme' => 'Theme',
            'pagination' => 'Pagination',
            'site_title' => 'Site Title',
            'site_description' => 'Site Description',
            'keywords' => 'Keywords',
            'mail_template' => 'Mail Template',
        ];
    }
}
