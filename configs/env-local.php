<?php

define('YII_DEBUG', true);
define('YII_ENV', 'dev');

$config = [
    'id' => 'testenv',
    'siteTitle' => 'LUYA Test Env',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'cms',
    'modules' => [
        // modules folder
        'cms' => 'luya\cms\frontend\Module',
        'cmsadmin' => [
            'class' => 'luya\cms\admin\Module',
        ],
        'admin' => [
            'class' => 'luya\admin\Module',
            'interfaceLanguage' => 'en',
            'secureLogin' => false,
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
        'assetManager' => [
            'class' => 'luya\web\AssetManager',
            'linkAssets' => true,
        ],
    ],
    'bootstrap' => [
        'luya\cms\frontend\Bootstrap', 'luya\admin\Bootstrap',
    ]
];


if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = ['class'=> 'yii\debug\Module', 'allowedIPs' => ['*']];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = ['class'=> 'yii\gii\Module', 'allowedIPs' => ['*']];
}

return \yii\helpers\ArrayHelper::merge($config, require('env-local-db.php'));