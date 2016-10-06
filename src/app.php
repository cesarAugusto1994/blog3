<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

define('FACEBOOK_API_KEY',    '');
define('FACEBOOK_API_SECRET', '');
define('TWITTER_API_KEY',     '');
define('TWITTER_API_SECRET',  '');
define('GOOGLE_API_KEY',      '580049489359-vo5entgjvhmt9oamkbctic0ul5ris81l.apps.googleusercontent.com');
define('GOOGLE_API_SECRET',   'vqCx5mIL6uxLP6X4sNlZIank');
define('GITHUB_API_KEY',      '');
define('GITHUB_API_SECRET',   '');

include __DIR__ . '/../app/bootstrap.php';
include __DIR__ . '/../app/cli-config.php';

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());

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
        'pattern' => '^/admin/|^/user/',
        'form' => array(
            'login_path' => '/login',
            'check_path' => '/admin/login_check',
            'always_use_default_target_path' => true,
            'default_target_path' => '/redirect',
        ),
        'logout' => array(
            'logout_path' => '/admin/logout',
            'invalidate_session' => true,
        ),
        'remember_me' => array(
            'secret'   => '%secret%',
            'lifetime' => 604800, // 1 week in seconds
            'path'     => '/user/',
            // by default, the feature is enabled by checking a
            // checkbox in the login form (see below), uncomment
            // the following line to always enable it.
            'always_remember_me' => true,
        ),
        'users' => function () use ($app) {
            return new Security\UserProvider($app['db'], $app);
        },
    ),
    /*
    'default' => array(
        'pattern' => '^/',
        'anonymous' => true,
        'oauth' => array(
            'login_path' => '/auth/',
            'callback_path' => '/auth/Google/callback',
            'check_path' => '/auth/Google/check',
            'failure_path' => '/',
            'with_csrf' => true
        ),
        'logout' => array(
            'logout_path' => '/logout',
            'with_csrf' => true
        ),
        // OAuthInMemoryUserProvider returns a StubUser and is intended only for testing.
        // Replace this with your own UserProvider and User class.
        'users' => new Gigablah\Silex\OAuth\Security\User\Provider\OAuthInMemoryUserProvider()
    )*/
);
$app['security.access_rules'] = array(
    array('^/login$', 'IS_AUTHENTICATED_ANONYMOUSLY'),
    array('^/admin/$', 'ROLE_ADMIN'),
    array('^/users/$', 'ROLE_ADMIN'),
    array('^/users/$', 'ROLE_USER'),
    array('^/auth', 'ROLE_USER')
);
$app['security.role_hierarchy'] = array(
    'ROLE_ADMIN' => array('ROLE_USER', 'ROLE_ALLOWED_TO_SWITCH'),
);

$app->register(new \Silex\Provider\SessionServiceProvider());
$app['session.storage.save_path'] = __DIR__ . '/../var/cache/sessions/';
$app['session.storage.options'] = ['cookie_lifetime' => 3600];
$app['session']->start();
$app->register(new Silex\Provider\RememberMeServiceProvider());

$app->register(new \Silex\Provider\TwigServiceProvider(),
    array(
        'twig.path' => __DIR__ . '/../src/Api/Resources/Views/',
        'twig.options' => array(
            'cache' => __DIR__ . '/../var/cache/twig',
            'strict_variables' => true,
        ),
    )
);
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...
    
    return $twig;
});
$app->register(new \Silex\Provider\FormServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

include_once __DIR__ . '/../app/services.php';
include_once __DIR__ . '/../app/providers.php';
include_once __DIR__ . '/../app/routes.php';
include_once __DIR__ . '/../app/middlewares.php';

return $app;
