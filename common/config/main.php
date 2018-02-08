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
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=coca',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'co_',
        ],
        'log' => [
            'flushInterval' => 100,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    // 'class' => 'yii\log\DbTarget',
                    'exportInterval' => 10,
                    'levels' => ['info', 'error', 'profile'],
                    'except' => [
                       // 'yii\db\*',
                    ],
                    'logFile' => '@app/runtime/logs/'.date('Y-m-d').'.log',
                ],
            ],
        ],
        'urlManager' => [
            //'enableStrictParsing' => true,
            'rules' => [
                // ...
                'debug/<controller>/<action>' => 'debug/<controller>/<action>',
            ],
        ],
            // 'authManager' => [
        //     'class' => 'yii\rbac\DbManager', // 使用数据库管理配置文件
        // ],
    ],
    'bootstrap' => ['debug'],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
        ],
    ],
];
