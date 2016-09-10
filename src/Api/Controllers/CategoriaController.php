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
    public function index($colecaoId, Application $app)
    {
        $colecao = $app['colecao.repository']->find($colecaoId);
    
        return $app['twig']->render(
            'categorias.html.twig',
            ['categorias' => $app['categoria.repository']->findBy(['colecao' => $colecao, 'ativo' => true]),
            'colecao' => $colecao]
        );
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function categoriasGrid(Application $app)
    {
        $colecoes = $app['colecao.repository']->findBy(['ativo' => true]);
        $categorias = $app['categoria.repository']->findAll();

        return $app['twig']->render('admin/categorias.html.twig', ['categorias' => $categorias, 'colecoes' => $colecoes]);
    }
    
    /**
     * @param Application $app
     * @return mixed
     */
    public function getCategoriasByColecao($colecaoId, Application $app)
    {
        $colecao = $app['colecao.repository']->find($colecaoId);
        $colecoes = $app['colecao.repository']->findBy(['ativo' => true]);
        $categorias = $app['categoria.repository']->findBy(['colecao' => $colecao]);
        
        return $app['twig']->render('admin/categorias.html.twig', ['categorias' => $categorias, 'colecoes' => $colecoes, 'colecao' => $colecao]);
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function novo(Request $request, Application $app)
    {
        $categoria = new Categoria();
        
        $colecao = $app['colecao.repository']->find($request->get('colecao'));
        
        $categoria->setNome($request->get('nome'));
        $categoria->setColecao($colecao);
        $categoria->setAtivo(true);

        $app['categoria.repository']->save($categoria);

        return $app->redirect('categorias_grid');
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editar(Request $request, Application $app)
    {
        $categoria = $app['categoria.repository']->find($request->get('id'));

        $categoria->setNome($request->get('nome'));

        $app['categoria.repository']->save($categoria);

        return $app->redirect('categorias_grid');
    }
    
    public function alteraStatus()
    {
        
    }
}