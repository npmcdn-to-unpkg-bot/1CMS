<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $accesstoken
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $email_confirm_token
 * @property string $secret_key
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'email', 'auth_key', 'status'], 'required'],
            [['status'], 'integer'],
            [['username'], 'string', 'max' => 15],
            [['password_hash', 'accesstoken', 'auth_key', 'email_confirm_token', 'secret_key'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 50],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'accesstoken' => 'Accesstoken',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'status' => 'Status',
            'email_confirm_token' => 'Email Confirm Token',
            'secret_key' => 'Secret Key',
        ];
    }
}
