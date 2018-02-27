<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'timeZone' => 'Asia/Shanghai',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\PtUser',
            'enableAutoLogin' => true,
            'enableSession'=> false,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'profile'],
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
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/question-chapter'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/map'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/rank'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/record'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/prop', 'extraPatterns'=>['POST'=>'update']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/piece'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/battle'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/msg'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/day', 'extraPatterns'=>['POST'=>'update']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/chapter'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/game', 'extraPatterns'=>['POST'=>'update']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/boss', 'extraPatterns'=>['POST'=>'battle']],

                
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
        
        
    ],
    'modules' => [
        'v1' => [
            'class' => 'frontend\module\v1\Module',
        ],
    ],
    'params' => $params,
];
