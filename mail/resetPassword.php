<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

use app\modules\admin\models\Settings;

$letter = Settings::findOne(1)->mail_template;

$username = $user->username;

$message = Html::a('For password reset click link',
    Yii::$app->urlManager->createAbsoluteUrl([
            '/site/reset-password', 'key' => $user->secret_key
        ]
    ));

$letter = str_replace('[username]', $username, $letter);
$letter = str_replace('[followlink]', $message, $letter);

echo $letter;