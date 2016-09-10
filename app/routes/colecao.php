<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:31
 */

$app->get('/colecao', function() use ($app){
    return $app['colecao.controller']->index($app);
})->bind('colecao');

$app->get('/colecoes_grid', function() use ($app){
    return $app['colecao.controller']->colecoesGrid($app);
})->bind('colecoes_grid');