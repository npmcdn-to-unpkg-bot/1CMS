<?php
/**
 * @var $this yii\web\View
 * @var $user \app\models\User
 */

use yii\helpers\Html;
use app\modules\admin\models\Settings;

$letter = Settings::findOne(1)->mail_template;

$username = $user->username;

$message = Html::a('For account activation click this link',
    Yii::$app->urlManager->createAbsoluteUrl(
        [
            '/site/activate-account',
            'key' => $user->secret_key
        ]
    ));

$letter = str_replace('[username]', $username, $letter);
$letter = str_replace('[followlink]', $message, $letter);

echo $letter;