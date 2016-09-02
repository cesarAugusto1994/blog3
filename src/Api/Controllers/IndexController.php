<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 09:13
 */

namespace Api\Controllers;

use Api\Entities\Posts;
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
        $offset = 0;
        $limit = 3;
        $firstPage = 1;
        $nextPage = 0;

        $posts = $app['posts.repository']->findBy(['ativo' => true], ['cadastro' => 'DESC']);
        $count = count($posts);
        $countPages = (int)ceil(($count ? $count : 1 )/ $limit);

        if ($page > 1 && $page <= $countPages) {
            for ($i = 0; $i < $page; $i++) {
                $offset = $page * 2 - 1;
            }
        } elseif ($page >= $countPages) {
            $page = $countPages;
        }

        $results = $app['posts.repository']->getAll($offset, $limit);

        if ($page < $countPages) {
            $firstPage = $page - 1;
            $nextPage = $page + 1;
        } elseif($page >= 1) {
            $firstPage = $page - 1;
        }

        return $app['twig']->render('index.html.twig', [
            'posts' => $results,
            'firstPage' => $firstPage,
            'nextPage' => $nextPage,
            'limitPerPage' => $limit,
            'records' => $count
        ]);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function login(Request $request, Application $app)
    {
        return $app['twig']->render('login.html.twig', array(
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
        return $app['twig']->render('about.html.twig', []);
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function contact(Application $app)
    {
        return $app['twig']->render('contact.html.twig', []);
    }
}