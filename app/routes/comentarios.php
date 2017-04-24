<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 24/04/17
 * Time: 11:38
 */

$comentarios = $app['controllers_factory'];

$comentarios->get('/', function () use ($app) {

    $comentarios = $app['comentario.repository']->findBy([], ['id' => 'DESC'], 70);
    return $app['twig']->render('comentarios/index.html.twig', ['comentarios' => $comentarios]);

});


return $comentarios;