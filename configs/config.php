<?php

use luya\Config;

define('YII_DEBUG', true);
define('YII_ENV', 'local');

$config = new Config('testenv', dirname(__DIR__), [
    'siteTitle' => 'LUYA Test Env',
    'defaultRoute' => 'cms',
    'remoteToken' => 'foobar',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'cms' => 'luya\cms\frontend\Module',
        'cmsadmin' => [
            'class' => 'luya\cms\admin\Module',
        ],
        'admin' => [
            'class' => 'luya\admin\Module',
            'interfaceLanguage' => 'en',
            'secureLogin' => false,
            'publicOpenApi' => true,
        ],
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['*'],
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*'],
        ]
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
        'assetManager' => [
            'class' => 'luya\web\AssetManager',
            'linkAssets' => true,
        ],
    ],
    'bootstrap' => [
        'luya\cms\frontend\Bootstrap', 'luya\admin\Bootstrap', 'debug'
    ]
]);

$config->component('db', [
    'dsn' => 'mysql:host=luya_db;dbname=luya_env_dev',
    'username' => 'luya',
    'password' => 'luya',
])->env(Config::ENV_LOCAL);

return $config;