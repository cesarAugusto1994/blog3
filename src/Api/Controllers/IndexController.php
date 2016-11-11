<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 09:13
 */

namespace Api\Controllers;

use Api\Entities\Posts;
use App\Controllers\DataPostagem;
use App\Controllers\PagerController;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IndexController
 * @package Api\Controllers
 */
class IndexController
{
    /**
     * @param int $page
     * @param Application $app
     * @return mixed
     */
    public function index($page = 1, Application $app)
    {
        $pager = $app['pager.Controller'];
        $musicas = $app['musica.repository']->findBy(['ativo' => true], ['cadastro' => 'DESC'], 6);
        $tipo = $app['tipo.anexo.repository']->find(4);
        $videos = $app['musica.anexos.repository']->findBy(['tipo' => $tipo], ['cadastro' => 'DESC'], 3);
        $pager->pager($app['posts.repository']->findBy(['ativo' => true], ['cadastro' => 'DESC']), $page);

        return $app['twig']->render('index.html.twig', [
            'posts' => $app['posts.repository']->getAll($pager->getOffset(), $pager->getLimit()),
            'firstPage' => $pager->getFirstPage(),
            'nextPage' => $pager->getNextPage(),
            'limitPerPage' => $pager->getLimit(),
            'records' => $pager->getCountData(),
            'musicas' => $musicas,
            'videos' => $videos
        ]);
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function about(Application $app)
    {
        return $app['twig']->render('/user/about.html.twig', []);
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function contact(Application $app)
    {
        return $app['twig']->render('/user/contact.html.twig', []);
    }
}