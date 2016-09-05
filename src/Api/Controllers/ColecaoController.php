<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:39
 */

namespace Api\Controllers;


use Silex\Application;

class ColecaoController
{
    public function index(Application $app)
    {
        return $app['twig']->render('admin/colecoes.html.twig');
    }
}