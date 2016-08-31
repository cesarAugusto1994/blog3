<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 15:26
 */

namespace App\Controllers;


use Silex\Application;

class WidgetsController
{
    public function getAll(Application $app)
    {
        return $app['widgets.repository']->findAll();
    }
}