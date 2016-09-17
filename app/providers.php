<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 09:28
 */
/*
$app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => array(
        'default' => array(
            'dbname' => 'bloggrupopolo',
            'user' => 'cezzaar',
            'password' => 'elpro1973',
            'host' => 'mysql796.umbler.com',
            'driver' => 'pdo_mysql',
        )
    ),
));
*/
$app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => array(
        'default' => array(
            'dbname' => 'blog',
            'user' => 'root',
            'password' => 'mestre',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
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
        ),
    ),
));

$app->register(new \Silex\Provider\ServiceControllerServiceProvider());

$app->register(new \Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => __DIR__ . '/../src/Api/Resources/Views/',
        'twig.options' => array(
            'cache' => __DIR__ . '/../var/cache/twig',
            'strict_variables' => true,
        ),
    )
);

$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
));

$app->register(new \Silex\Provider\SessionServiceProvider(), array(
    'session.storage.save_path' => dirname(__DIR__) . '/../var/cache/sessions/'
));
$app['session']->start();

$app->register(new \Silex\Provider\HttpCacheServiceProvider(), array(
    'http.cache.cache_dir' => __DIR__.'/../var/cache/http/'
));

$app->register(new Silex\Provider\SecurityServiceProvider());
$app['security.default_encoder'] = function ($app) {
    return $app['security.encoder.digest'];
};
$app['security.encoder.digest'] = function () {
    return new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha1', false, 1);
};
$app['security.encoder_factory'] = function ($app) {
    return new \Symfony\Component\Security\Core\Encoder\EncoderFactory(
        array(
            'Symfony\Component\Security\Core\User\UserInterface' => $app['security.encoder.digest'],
            'Entity\User' => $app['security.encoder.digest'],
        )
    );
};
$app['security.firewalls'] = array(
    'secured' => array(
        'pattern' => '^/admin/',
        'form' => array(
            'login_path' => '/login',
            'check_path' => '/admin/login_check',
            'always_use_default_target_path' => true,
            'default_target_path' => '/',
        ),
        'logout' => array(
            'logout_path' => '/admin/logout',
            'invalidate_session' => true,
        ),
        'users' => function () use ($app) {
            return new Security\UserProvider($app['db']);
        },
    ),
);
$app['security.access_rules'] = array(
    array('^/login$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
    array('^/admin/$', 'ROLE_USER'),
    array('^/users/$', 'ROLE_USER')
);
$app['security.role_hierarchy'] = array(
    'ROLE_ADMIN' => array('ROLE_USER', 'ROLE_ALLOWED_TO_SWITCH'),
);
