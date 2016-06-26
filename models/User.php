<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;


/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $secret_key
 * @property string $accesstoken
 * @property string $email
 * @property string $auth_key
 * @property string $status
 * @property string $email_confirm_token
 */

class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 2;

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
            [['username', 'password_hash', 'accesstoken', 'email', 'auth_key'], 'required'],
            [['username'], 'string', 'max' => 15],
            [['password_hash', 'accesstoken', 'email', 'auth_key'], 'string', 'max' => 100],
            [['status'], 'integer'],
            [['secret_key'], 'unique'],
            [['username', 'email'], 'unique'],
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
            'password_hash' => 'Password',
            'accesstoken' => 'Accesstoken',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'status' => 'Status',
            'email_confirm_token' => 'Email Confirm Token',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function afterSave($insert, $changedAttributes)
     {
         parent::afterSave($insert, $changedAttributes);
         $auth = \Yii::$app->authManager;
         $editor = $auth->getRole('editor');
         if (!$insert) {
             $auth->revokeAll($this->id);
         }
         $auth->assign($editor, $this->id);
     }

    public static function isSecretKeyExpire($key)
    {
        if (empty($key))
            return false;
        $expire = Yii::$app->params['secretKeyExpire'];
        $parts = explode('_', $key);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }

    public static function findBySecretKey($key)
    {
        if (!static::isSecretKeyExpire($key))
            return null;
        return static::findOne([
            'secret_key' => $key
        ]);
    }

    public function generateSecretKey()
    {
        $this->secret_key = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removeSecretKey()
    {
        $this->secret_key = null;
    }


}
