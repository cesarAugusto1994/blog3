<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new \Silex\Provider\FormServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

include_once __DIR__ . '/../app/services.php';
include_once __DIR__ . '/../app/providers.php';
include_once __DIR__ . '/../app/routes.php';
include_once __DIR__ . '/../app/middlewares.php';

return $app;
