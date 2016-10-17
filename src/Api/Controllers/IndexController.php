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
        $pager->pager($app['posts.repository']->findBy(['ativo' => true], ['cadastro' => 'DESC']), $page);

        return $app['twig']->render('index.html.twig', [
            'posts' => $app['posts.repository']->getAll($pager->getOffset(), $pager->getLimit()),
            'firstPage' => $pager->getFirstPage(),
            'nextPage' => $pager->getNextPage(),
            'limitPerPage' => $pager->getLimit(),
            'records' => $pager->getCountData()
        ]);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function login(Request $request, Application $app)
    {
        return $app['twig']->render('login-new.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ));
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
    
    /**
     * @param Application $app
     * @return mixed
     */
    public function userIndex(Application $app)
    {
        $logs = $app['log.repository']->findBy([], ['cadastro' => 'DESC'], 1);
        $musicas = $app['musica.repository']->findBy([], ['cadastro' => 'DESC'], 1);
        $musicaAnexos = $app['musica.anexos.repository']->findBy([], ['cadastro' => 'DESC'], 1);
        $posts = $app['posts.repository']->findBy([], ['cadastro' => 'DESC'], 1);
        $colecoes = $app['colecao.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);

        return $app['twig']->render('/user/index.html.twig', [
            'logs' => $logs,
            'musicas' => $musicas,
            'musica_anexos' => $musicaAnexos,
            'posts' => $posts,
            'colecoes' => $colecoes
        ]);
    }
}