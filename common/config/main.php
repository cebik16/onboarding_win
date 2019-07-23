<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.mailtrap.io',
                'username' => 'df22e9debd10ab',
                'password' => '4bceae32891665',
                'port' => '2525',
                'encryption' => 'tls',
            ],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
//             'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
        'urlManagerFrontend' =>[
            'enablePrettyUrl' => true,
            'class' => 'yii\web\UrlManager',
//            'showScriptName'=>false,
            'hostInfo' => 'http://onboarding.local.ew',
            'baseUrl' => 'http://onboarding.local.ew',
    
        ],
    ],

];
