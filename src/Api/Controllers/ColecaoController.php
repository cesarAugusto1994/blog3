<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:39
 */

namespace Api\Controllers;


use Api\Entities\Colecao;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ColecaoController
{
    public function index(Application $app)
    {
        return $app['twig']->render('colecoes.html.twig', ['colecoes' => $app['colecao.repository']->findAll()]);
    }
    
    public function colecoesGrid(Application $app)
    {
        return $app['twig']->render('admin/colecoes.html.twig', ['colecoes' => $app['colecao.repository']->findAll()]);
    }
    
    public function novo(Request $request, Application $app)
    {
        $colecao = new Colecao();
        
        $colecao->setNome($request->get('nome'));
        $colecao->setDescricao($request->get('descricao'));
        //$colecao->setImagem($request->get('imagem'));
        $colecao->setAtivo(true);
        
        $app['colecao.repository']->save($colecao);
    
        return $app->redirect('/colecoes_grid');
    }
    
    public function editar(Request $request, Application $app)
    {
        $colecao = $app['colecao.repository']->find($request->get('id'));
    
        $colecao->setNome($request->get('nome'));
        $colecao->setDescricao($request->get('descricao'));
        //$colecao->setImagem($request->get('imagem'));
        
        $app['colecao.repository']->save($colecao);
        
        return $app->redirect('/colecoes_grid');
    }
}