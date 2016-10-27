<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:39
 */

namespace Api\Controllers;

use Api\Entities\Colecao;
use App\Controllers\UploadImages;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ColecaoController
 * @package Api\Controllers
 */
class ColecaoController
{
    /**
     * @param Application $app
     * @return mixed
     */
    public function index(Application $app)
    {
        
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function colecoesGrid(Application $app)
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
    
    /**
     * @param $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function alteraStatus($id, Application $app)
    {
        
    }
}