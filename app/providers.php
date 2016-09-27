<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 09:28
 */

$app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => array(
        'default' => array(
            'dbname' => $app['database.blog']['dbname'],
            'user' => $app['database.blog']['user'],
            'password' => $app['database.blog']['password'],
            'host' => $app['database.blog']['host'],
            'driver' => $app['database.blog']['driver'],
        )
    ),
));

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

$app->register(new \Silex\Provider\SessionServiceProvider());
$app['session.storage.save_path'] = __DIR__ . '/../var/cache/sessions/';
$app['session.storage.options'] = ['cookie_lifetime' => 3600];
/*
$app['session.db_options'] = array(
    'db_table' => 'session',
    'db_id_col' => 'session_id',
    'db_lifetime_col' => 'session_lifetime',
    'db_data_col' => 'session_value',
    'db_time_col' => 'session_time',
);
$app['session.storage.handler'] = function () use ($app) {
    return new \Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler(
        $app['db']->getWrappedConnection(),
        $app['session.db_options'],
        $app['session.storage.options']
    );
};*/
$app['session']->start();

$app->register(new \Silex\Provider\HttpCacheServiceProvider(), array(
    'http.cache.cache_dir' => __DIR__.'/../var/cache/http/'
));


