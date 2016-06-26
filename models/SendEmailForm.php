<?php
namespace app\models;

use Yii;
use yii\base\Model;


class SendEmailForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => User::className(),
                'filter' => [
                    'status' => User::STATUS_ACTIVE
                ],
                'message' => 'This email address is not registered'
            ],
        ];
    }

    public function attributeLabels()
    {
        return ['email' => 'Email'];
    }

    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne(
            [
                'status' => User::STATUS_ACTIVE,
                'email' => $this->email
            ]
        );

        if ($user):
            $user->generateSecretKey();

            if ($user->save(false)):
                return Yii::$app->mailer->compose('resetPassword', ['user' => $user])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . '(send by robot)'])
                    ->setTo($this->email)
                    ->setSubject('Restore password for' . Yii::$app->name)
                    ->send();
            endif;
        endif;
        return false;
    }
}