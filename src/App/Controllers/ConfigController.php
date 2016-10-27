<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 10:20
 */

namespace App\Controllers;

use App\Entities\Config;
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
        
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function novo(Request $request, Application $app) 
    {
       
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editar(Request $request, Application $app)
    {
        
    }
}