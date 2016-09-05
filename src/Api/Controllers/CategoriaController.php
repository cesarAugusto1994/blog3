<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:28
 */

namespace Api\Controllers;

use Api\Entities\Categoria;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoriaController
 * @package Api\Controllers
 */
class CategoriaController
{
    /**
     * @param Application $app
     * @return mixed
     */
    public function index(Application $app)
    {
        $colecoes = $app['colecao.repository']->findBy(['ativo' => true]);
        $categorias = $app['categoria.repository']->findAll();
        
        return $app['twig']->render('admin/categorias.html.twig', ['categorias' => $categorias, 'colecoes' => $colecoes]);
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function novo(Request $request, Application $app)
    {
        $categoria = new Categoria();
        
        $colecao = $app['colecao.repository']->find(1);
        
        $categoria->setNome($request->get('nome'));
        $categoria->setColecao($colecao);
        
        $app['categoria.repository']->save($categoria);

        return $app->redirect('/categorias');
    }
    
    public function editar()
    {
        
    }
    
    public function alteraStatus()
    {
        
    }
}