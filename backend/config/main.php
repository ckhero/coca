<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            // 'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/chapter-item'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/question'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/level'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/login'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/prop'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/map'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/chapter'],
                
               // ['class' => 'yii\rest\UrlRule', 'controller' => 'upload'],
                [
                    'class' => 'yii\web\UrlRule',
                    'pattern' => 'site/gen-swg',
                    'route' => 'site/gen-swg'
                ],
            ],
        ],
        'request' =>
        [

            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]

        ],
        // 'authManager' => [
        //     'class' => 'yii\rbac\DbManager', // 使用数据库管理配置文件
        // ]
    ],
    'modules' => [
        'v1' => [
            'class' => 'backend\modules\v1\Module',
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
             'layout' => 'left-menu',//yii2-admin的导航菜单
        ],
    ],

    // 'as access' => [
    //     'class' => 'mdm\admin\components\AccessControl',
    //     'allowActions' => [
    //         'site/*',//允许访问的节点，可自行添加
    //         'admin/*',//允许所有人访问admin节点及其子节点
    //     ]
    // ],
    'params' => $params,
];
