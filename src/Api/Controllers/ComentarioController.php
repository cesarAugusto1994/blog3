<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 17/10/16
 * Time: 16:22
 */

namespace Api\Controllers;

use Api\Entities\Comentarios;
use Symfony\Component\Console\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ComentarioController
 * @package Api\Controllers
 */
class ComentarioController
{
    /**
     * @param Request $request
     * @param \Silex\Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function criar(Request $request, \Silex\Application $app)
    {
        
    }
    
    /**
     * @param $id
     * @param \Silex\Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function remover($id, \Silex\Application $app)
    {
       
    }
}