<?php

/**
 * @author	<AUTHOR_DATA_PLACEHOLDER>
 * @version	1.0
 */
return [
    'name' => 'My Company',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'es-ES',
    'aliases' => [
        '@custom' => dirname(dirname(__DIR__)) . '/custom',
        '@platform' => dirname(dirname(__DIR__))
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => '/'
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US'
                ],
            ],
        ],
        'formatter' => [
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'EUR',
            'numberFormatterOptions' => [
                NumberFormatter::MIN_FRACTION_DIGITS => 0,
                NumberFormatter::MAX_FRACTION_DIGITS => 2,
            ],
            'defaultTimeZone' => 'UTC',
            'timeZone' => 'Europe/Madrid',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.zoho.com',
                'username' => '',
                'password' => '',
                'port' => ' 587',
                'encryption' => 'tls',
            ],
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
    ],
];
