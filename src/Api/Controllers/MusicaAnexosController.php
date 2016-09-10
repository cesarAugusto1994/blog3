<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 11:54
 */

namespace Api\Controllers;

use Silex\Application;

/**
 * Class MusicaAnexosController
 * @package Api\Controllers
 */
class MusicaAnexosController
{
    /**
     * @param $musicaId
     * @param Application $app
     * @return mixed
     */
    public function index($musicaId, Application $app)
    {
        $musica = $app['musica.repository']->find($musicaId);
        
        return $app['twig']->render('musica_anexos.html.twig', 
            [
                'anexos' => $app['musica.anexos.repository']->findBy(['musica' => $musica, 'ativo' => true]),
                'musica' => $musica
            ]);
    }
}