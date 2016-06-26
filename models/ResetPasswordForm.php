<?php

namespace app\models;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\base\InvalidParamException;

class ResetPasswordForm extends Model
{
    public $password;
    private $_user;

    public function rules()
    {
     return[
         ['password', 'required']
     ];
    }

    public function attributeLabels()
    {
        return ['password'=>'Password'];
    }

    public function __construct($key, $config = [])
    {
        if(empty($key) || !is_string($key))
            throw new InvalidParamException('Key cant be empty');
        $this->_user = User::findBySecretKey($key);
        if(!$this->_user) throw new InvalidParamException('Broken key');
        parent::__construct($config);
    }

    public function resetPassword(){
        /* @var $user User */
        $user = $this->_user;
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        $user->removeSecretKey();
        return $user->save(false);
    }
}