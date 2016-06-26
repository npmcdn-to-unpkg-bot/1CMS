<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'view' => [
            'class' => 'yii\web\View',
//            'theme' => [
//                'basePath' => '@webroot/themes/basic',
//                'baseUrl' => '@web/themes/basic',
//                'pathMap' => [
//                    '@app/views' => '@webroot/themes/basic/views',
//                    '@app/modules' => '@webroot/themes/basic/modules',
//                    '@app/components' => '@webroot/themes/basic/widgets',
//                ],
//            ],
//            'class' => 'yii\web\View',
            'theme' => [
                'basePath' => '@webroot/themes/color',
                'baseUrl' => '@web/themes/color',
                'pathMap' => [
                    '@app/views' => '@webroot/themes/color/views',
                    '@app/modules' => '@webroot/themes/color/modules',
                    '@app/components' => '@webroot/themes/color/widgets',
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'UPkh7lJ_Gu98A92WWEMY_x1iCfHhoQya',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'login' => 'site/login',
            ],
        ],
        'assetManager' => [
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets'
        ],
    ],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\AdminModule',
            'layout' => 'main',
        ],
        'blog' => [
            'class' => 'app\modules\blog\Module',
            'layout' => 'main',
        ],
//        'request-log' => [
//            'class' => Zelenin\yii\modules\RequestLog\Module::className(),
//            // username attribute in your identity class (User)
//            'usernameAttribute' => 'name'
//        ]
    ],

    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
