<?php

ini_set('display_errors', E_ALL);

require_once __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../src/app.php';
$app['debug'] = true;
require __DIR__.'/../config/prod.php';
require __DIR__.'/../app/routes.php';
$app->run();
