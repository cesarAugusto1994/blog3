<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 29/09/16
 * Time: 09:31
 */

namespace Api\Controllers;

use Silex\Application;

/**
 * Class SearchController
 * @package Api\Controllers
 */
class SearchController
{
    /**
     * @param $search
     * @param Application $app
     * @return mixed
     */
    public function search($search, Application $app) {

        $musicas = [];
        $musicaAnexos = [];
        $posts = [];

        if ($search) {
            $musicas = $app['musica.repository']->search($search);
            $musicaAnexos = $app['musica.anexos.repository']->search($search);
            $posts = $app['posts.repository']->search($search);
        }
        
        return $app['twig']->render(
            'user/search.html.twig',
            [
                'musicas' => $musicas, 
                'musica_anexos' => $musicaAnexos, 
                'posts' => $posts
            ]
        );
    }
    
    public function searchPublic($search, Application $app) {
        
        $musicas = [];
        $musicaAnexos = [];
        $posts = [];
        
        if ($search) {
            $musicas = $app['musica.repository']->search($search);
            $musicaAnexos = $app['musica.anexos.repository']->search($search);
            $posts = $app['posts.repository']->search($search);
        }
        
        return $app['twig']->render(
            'search.html.twig',
            [
                'musicas' => $musicas,
                'musica_anexos' => $musicaAnexos,
                'posts' => $posts
            ]
        );
    }
}