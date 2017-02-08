<?php

/**
 * @author	<AUTHOR_DATA_PLACEHOLDER>
 * @version	1.0
 */
$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend'
    , 'basePath' => dirname(__DIR__)
    , 'bootstrap' => ['log', 'captcha']
    , 'controllerNamespace' => 'frontend\controllers'
    , 'modules' => [
        'captcha' => [
            'class' => 'jlorente\captcha\Module'
            , 'cache' => [
                'class' => 'yii\caching\DbCache'
                , 'cacheTable' => 'yii_cache'
            ]
            , 'requestNumber' => 3
            , 'duration' => 120
        ]
        , 'moderator' => 'main\modules\moderator\Module'
        , 'event' => 'main\modules\event\Module'
        , 'poll' => 'main\modules\poll\Module'
        , 'question' => 'main\modules\question\Module'
    ]
    , 'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ]
        , 'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ], 'user' => [
            'class' => 'main\models\web\User'
            , 'identityClass' => 'main\models\core\Account'
            , 'loginUrl' => ['/site/login']
            , 'enableAutoLogin' => true
        ]
        , 'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0
            , 'targets' => [
                [
                    'class' => 'yii\log\FileTarget'
                    , 'levels' => ['error', 'warning']
                ]
            ]
        ]
        , 'errorHandler' => [
            'errorAction' => 'site/error'
        ]
        , 'view' => [
            'class' => 'main\models\web\View'
        ]
        , 'urlManager' => [
            'enableStrictParsing' => true
            , 'rules' => require 'urls.php'
        ]
    ]
    , 'params' => $params,
];