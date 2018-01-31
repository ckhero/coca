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
        // 'authManager' => [
        //     'class' => 'yii\rbac\DbManager', // 使用数据库管理配置文件
        // ],
    ],
    // 'modules' => [
    //     'admin' => [
    //         'class' => 'mdm\admin\Module',
    //         'layout' => 'left-menu',//yii2-admin的导航菜单
    //     ],
    // ],
];
