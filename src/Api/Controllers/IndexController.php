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
        if (isset($app['session'])) {
            return $app->redirect('/user/');
        }

        return $app['twig']->render('index.html.twig');
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