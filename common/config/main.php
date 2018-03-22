<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            //'class' => 'yii\caching\FileCache',
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                'database' => 0,
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=139.219.68.50;dbname=coca',
            'username' => 'coca',
            'password' => 'coca123o1nfdasof!@#!4',
            'charset' => 'utf8',
            'tablePrefix' => 'co_',
            // 'enableSchemaCache' => true,  //开启表结构缓存
            // 'schemaCacheDuration' => 3600, // 表结构缓存时间
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
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.*.*', '*'],
        ],
    ],
];
