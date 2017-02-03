<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 09:28
 */

$app->register(new \Silex\Provider\DoctrineServiceProvider(), [
    'db.options' => [
        'driver' => 'pdo_mysql',
        'host' => $app['database']['host'],
        'dbname' => $app['database']['dbname'],
        'user' => $app['database']['user'],
        'password' => $app['database']['password'],
        'charset' => 'utf8mb4',
    ],
]);

$app->register(new \Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider(), array(
    'orm.proxies_dir' => __DIR__.'/../var/cache/doctrine/',
    'orm.em.options' => array(
        'mappings' => array(
            array(
                'type' => 'annotation',
                'namespace' => 'Api\Entities',
                'path' => __DIR__ . '/../src',
                'use_simple_annotation_reader' => false
            ),
            array(
                'type' => 'annotation',
                'namespace' => 'Api\Controller',
                'path' => __DIR__ . '/../src',
                'use_simple_annotation_reader' => false
            ),
            array(
                'type' => 'annotation',
                'namespace' => 'App\Entities',
                'path' => __DIR__ . '/../src',
                'use_simple_annotation_reader' => false
            ),
            array(
                'type' => 'annotation',
                'namespace' => 'App\Services',
                'path' => __DIR__ . '/../src',
                'use_simple_annotation_reader' => false
            ),
        ),
    ),
));
$app->register(new Moust\Silex\Provider\CacheServiceProvider(), array(
    'cache.options' => array(
        'driver' => 'apc'
    )
));
$app->register(new \Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
));
$app->register(new Silex\Provider\SwiftmailerServiceProvider());
$app['swiftmailer.options'] = array(
    'driver' => 'smtp',
    'host' => 'smtp.gmail.com',
    'port' => 465,
    'username' => 'cezzaar@gmail.com',
    'password' => 'Cesar1507',
    'encryption' => 'ssl',
    'auth_mode' => null,
    'pretend' =>false
);
$app->register(new \Silex\Provider\HttpCacheServiceProvider(), array(
    'http.cache.cache_dir' => __DIR__.'/../var/cache/http/'
));

