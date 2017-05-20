<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 02/02/17
 * Time: 13:41
 */

use Api\Entities\Favoritos;
use Symfony\Component\HttpFoundation\Request;

$favoritos = $app['controllers_factory'];

$favoritos->get('favorites', function() use ($app) {

    $favorito = $app['favoritos.repository']->findBy(['usuario' => $app['usuario']]);
    return $app['twig']->render('/user/favoritos.html.twig', ['favoritos' => $favorito]);

})->bind('favorites_view');

return $favoritos;