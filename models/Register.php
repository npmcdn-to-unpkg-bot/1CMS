<?php

namespace app\models;

use Yii;
use app\modules\admin\models\Settings;
use app\modules\admin\models\Profiles;


/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property string $token
 * @property string $email
 * @property string $secret_key
 * @property int $status
 */
class Register extends \yii\db\ActiveRecord
{
    public $status;
    public $title;
    public $appname;

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
            ['username', 'filter', 'filter' => 'trim'],
            ['email', 'filter', 'filter' => 'trim'],
            ['password_hash', 'filter', 'filter' => 'trim'],
            [['username', 'password_hash', 'email'], 'required'],
            [['username', 'password_hash'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['username'], 'unique', 'message' => 'Username already registered'],
            [['email'], 'unique', 'message' => 'Email already registered'],
            [['status'], 'default', 'value' => User::STATUS_ACTIVE, 'on' => 'default'],
            [['status'], 'default', 'value' => User::STATUS_WAIT, 'on' => 'emailActivation'],
            [['accesstoken', 'auth_key', 'secret_key'], 'string'],
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
            'email' => 'Email',
        ];
    }

    public function reg()
    {
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
        $user->status = User::STATUS_WAIT;
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->accesstoken = Yii::$app->security->generateRandomString() . '_' . time();
        $user->generateSecretKey();
        if ($this->scenario === 'emailActivation')
            $user->generateSecretKey();
        return $user->save() ? $user : null;
    }

    public function sendActivationEmail($user)
    {
        $this->title = Settings::findOne(1);
        $this->appname = $this->title->site_title;
        return Yii::$app->mailer->compose('activationEmail', ['user' => $user])
            ->setFrom([Yii::$app->params['supportEmail'] => $this->appname . ' (sent by Robot)'])
            ->setTo($this->email)
            ->setSubject('Activation for ' . $this->appname)
            ->send();
    }
}
