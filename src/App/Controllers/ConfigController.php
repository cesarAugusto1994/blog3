<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 10:20
 */

namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ConfigController
{
    /**
     * @param Application $app
     * @return mixed
     */
    public function index(Application $app)
    {
        return $app['config.repository']->find(1);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editar(Request $request, Application $app)
    {
        $config = $app['config.repository']->find($request->get('id'));
        $config->setNome($request->get('nome'));

        $app['config.repository']->save($config);

        return $app->redirect('/blog/settings');
    }
}