<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'KKLUuh70Wx_ZrEmXCBdnucYI8hDQr23K',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User1',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
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
        'db' => $db,
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // 'GET test' => 'test/testid',
                'GET /' => 'auth/web',
                'gii' => 'gii',
                'GET login' => 'auth/loginget',
                'GET logout' => 'auth/logout',
                'POST login' => 'auth/loginpost',
                'GET info' => 'auth/viewinfo',
                'PATCH info' => 'auth/editinfo',
                'GET admin/user' => 'admin/viewusers',
                'POST admin/user' => 'admin/adduser',
                'GET admin/user/<id>' => 'admin/viewoneuser',
                'PATCH admin/user/<id>' => 'admin/edituser',
                'DELETE admin/user/<id>' => 'admin/deleteuser',
                'GET admin/project' => 'admin/viewproject',
                'POST admin/project' => 'admin/addproject',
                'GET admin/project/<id>' => 'admin/viewoneproject',
                'PATCH admin/project/<id>' => 'admin/editproject',
                'DELETE admin/project/<id>' => 'admin/deleteproject',
            ],
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%auth_item}}',
            'itemChildTable' => '{{%auth_item_child}}',
            'assignmentTable' => '{{%auth_assignment}}',
            'ruleTable' => '{{%auth_rule}}',
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
