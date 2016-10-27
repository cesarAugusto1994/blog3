<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 10:41
 */

namespace Api\Controllers;

use Api\Entities\Categoria;
use Api\Entities\Musica;
use Api\Entities\Usuarios;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MusicaController
 * @package Api\Controllers
 */
class MusicaController
{
    /**
     * @param Application $app
     * @return mixed
     */
    public function index($categoriaId, Application $app)
    {

    }
    
    /**
     * @param int $categoria
     * @param Application $app
     * @param bool $roleUser
     * @return mixed
     */
    public function novaMusica($categoria, Application $app, $roleUser = false)
    {

    }
    
    /**
     * @param $id
     * @param Application $app
     * @return mixed
     */
    public function editarMusica($id, Application $app, $edicaoUsuario = false, $editarLetra = false)
    {

    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function musicasGrid(Application $app)
    {
        
    }
    
    /**
     * @param $categoriaId
     * @param Application $app
     * @return mixed
     */
    public function categoriaMusicasGrid($categoriaId, Application $app)
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
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editarLetra(Request $request, Application $app)
    {

    }

    /**
     * @param int $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function alteraStatus($id, Application $app)
    {
        
    }
    
    
}