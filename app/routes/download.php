<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 04/05/17
 * Time: 16:41
 */

use Api\Entities\Playlist;
use Api\Entities\PlaylistMusicas;
use Symfony\Component\HttpFoundation\Request;

$down = $app['controllers_factory'];

$down->get('/', function () use ($app) {

    $downloads = $app['anexo.download.repository']->findBy([]);

    return $app['twig']->render('/download/index.html.twig', ['downloads' => $downloads]);

})->bind('downloads');

return $down;
