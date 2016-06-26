<?php


namespace app\models;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;
//use yii\web\User;
use app\models\User;

/* @property string $username */

class AccountActivation extends Model
{
    /* @var $user \app\models\User */
    private $_user;

    public function __construct($key, $config=[])
    {
        if(empty($key) || !is_string($key))
            throw new InvalidParamException('Key cant be empty');
        $this->_user = User::findBySecretKey($key);
        if(!$this->_user)
            throw new InvalidParamException('Invalid activation key');
        parent::__construct($config);
    }

    public function activateAccount(){
        $user = $this->_user;
        $user->status=User::STATUS_ACTIVE;
        $user->removeSecretKey();
        return $user->save();
    }

    public function getUsername(){
        $user = $this->_user;
        return $user->username;
    }


}