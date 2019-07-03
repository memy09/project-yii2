<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name' => 'DocFile',
    'language' => 'th_TH',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ]
    ],
    'modules' => [
            // ...
            'gii' => [
                'class' => 'yii\gii\Module',
                'generators' => [
                    'mongoDbModel' => [
                        'class' => 'yii\mongodb\gii\model\Generator'
                    ]
                ],
            ],
            'gridview' =>  [
                'class' => '\kartik\grid\Module'
            ]
          ],
];
