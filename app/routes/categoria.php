<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:31
 */

$app->get('/categorias', function() use ($app){
    return $app['categoria.controller']->index($app);
});