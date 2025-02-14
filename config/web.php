<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf',
            'enableCsrfValidation' => true,
            'cookieValidationKey' => 'DtpaqPTg3Wef7LQjnt-NbdD2DKP_qLDU',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => true,
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
        'db' => $db,
        'assetManager' => [
            'bundles' => [
                'kartik\base\BootstrapAsset' => [
                    'sourcePath' => null,
                    'css' => ['https://stackpath.bootstrapcdn.com/bootstrap/5.2.0/css/bootstrap.min.css'],
                ],
                'kartik\base\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'js' => ['https://stackpath.bootstrapcdn.com/bootstrap/5.2.0/js/bootstrap.bundle.min.js'],
                ],  
            ],
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'tbl-proyecto/buscar-estudiante' => 'tbl-proyecto/buscar-estudiante',
                'tbl-proyecto/agregar-estudiante' => 'tbl-proyecto/agregar-estudiante',
                'tbl-f1/cargar' => 'tbl-f1/cargar',
                'carta/subir' => 'carta/subir',
            ],
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
?>
