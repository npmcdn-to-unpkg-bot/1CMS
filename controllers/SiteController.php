<?php

namespace app\controllers;

use app\models\Register;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EmailConfirmForm;
use app\models\User;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use app\models\SendEmailForm;
use app\models\ResetPasswordForm;
use app\models\AccountActivation;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\UploadForm;
use app\modules\admin\models\Settings;
use yii\base\Theme;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['reg', 'login', 'activate-account'],
                        'verbs' => ['GET', 'POST'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'search', 'send-email', 'reset-password',],
                        'roles' => ['@'],
                        'allow' => true,
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],


        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->redirect('/blog');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $emailActivation = Yii::$app->params['emailActivation'];
        $model = $emailActivation ? new Register(['scenario' => 'emailActivation']) : new Register();

        if ($model->load(Yii::$app->request->post()) && $model->validate()):
            if ($user = $model->reg()):
                if ($user->status === User::STATUS_ACTIVE):
                    Yii::$app->getSession()->setFlash('success', 'Подтвердите ваш электронный адрес.');
                    return $this->goHome();
                else:
                    if ($model->sendActivationEmail($user)):
                        Yii::$app->session->setFlash('success', 'Activation letter send to <strong>' . Html::encode($user->email) . '</strong>(check spam folders).');
                    else:
                        Yii::$app->session->setFlash('error', 'Error, message don\'t send');
                        Yii::error('Error mail sending');
                    endif;
                endif;
            else:
                Yii::$app->session->setFlash('error', 'Registration error');
                Yii::error('Registration Error');
                return $this->refresh();
            endif;
        endif;
        return $this->render('signup', [
            'model' => $model,
        ]);

    }

    public function actionActivateAccount($key)
    {
        try {
            $user = new AccountActivation($key);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user->activateAccount()):
            Yii::$app->session->setFlash('success', 'Activation successful! <strong>' . Html::encode($user->username) . '</strong> your confirmed your account');
        else:
            Yii::$app->session->setFlash('error', 'Activation error');
            Yii::error('Activation error!');
        endif;
        return $this->redirect(Url::to(['/site/login']));
    }


    public function actionEmailConfirm($token)
    {
        try {
            $model = new EmailConfirmForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->confirmEmail()) {
            Yii::$app->getSession()->setFlash('success', 'Спасибо! Ваш Email успешно подтверждён.');
        } else {
            Yii::$app->getSession()->setFlash('error', 'Ошибка подтверждения Email.');
        }
        return $this->goHome();
    }

    public function actionPasswordResetRequest()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Спасибо! На ваш Email было отправлено письмо со ссылкой на восстановление пароля.');
                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Извините. У нас возникли проблемы с отправкой.');
            }
        }
        return $this->render('passwordResetRequest', [
            'model' => $model,
        ]);
    }

    public function actionPasswordReset($token)
    {
        try {
            $model = new PasswordResetForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Спасибо! Пароль успешно изменён.');

            return $this->goHome();
        }

        return $this->render('passwordReset', [
            'model' => $model,
        ]);
    }

    public function actionSendEmail()
    {
        $model = new SendEmailForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->sendEmail()):
                    Yii::$app->getSession()->setFlash('warning', 'Check your email');
                    return $this->goHome();
                else:
                    Yii::$app->getSession()->setFlash('Error', 'Your cant reset password');
                endif;
            }
        }

        return $this->render('sendEmail', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($key)
    {
        try {
            $model = new ResetPasswordForm($key);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->resetPassword()) {
                Yii::$app->getSession()->setFlash('warning', 'Password was changed!');
                return $this->redirect(['/site/login']);
            }
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);

    }

    public function actionDownload($file)
    {
        $path = \Yii::getAlias('@webroot/uploads/media/');
        return Yii::$app->response->sendFile($path . $file);
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $theme = Settings::findOne(1)->theme;
//            var_dump($theme); die;
            Yii::$app->view->theme = new Theme([
                'basePath' => '@webroot/themes/' . $theme,
                'baseUrl' => '@web/themes/' . $theme,
                'pathMap' => [
//                    '@app/views' => '@webroot/themes/color/modules/blog/views',
//                    '@app/views' => '@webroot/themes/'.$theme.'/modules/blog/views',
                    '@app/views' => '@webroot/themes/' . $theme . '/views',
                    '@app/modules' => '@webroot/themes/' . $theme . '/modules',
//                    '@app/components' => '@webroot/themes/' . $theme . '/widgets',
                ]]);
//            var_dump(Yii::$app->view->theme); die;
            return true;  // or false if needed
        } else {
            return false;
        }
    }

}