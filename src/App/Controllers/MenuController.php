<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 20/08/16
 * Time: 11:00
 */

namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Entities\Menu;

/**
 * Class MenuController
 * @package App\Controllers
 */
class MenuController
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
     * @return mixed
     */
    public function criar(Request $request, Application $app)
    {
       
    }
    
    /**
     * @param $id
     * @param $app
     * @return mixed
     */
    public function alterarStatus($id, $app)
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