<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 08:41
 */

use Api\Entities\Categoria;

$musica = $app['controllers_factory'];

$musica->get('praises/added', function () use ($app) {
    return $app['twig']->render('/user/musicas-adicionadas.html.twig');
})->bind('musicas_adicionadas');

return $musica;