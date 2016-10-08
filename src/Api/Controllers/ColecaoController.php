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
        return $app['twig']->render(
            '/user/colecoes.html.twig',
            ['colecoes' => $app['colecao.repository']->findBy(['ativo' => true], ['nome' => 'ASC'])]
        );
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function colecoesGrid(Application $app)
    {
        return $app['twig']->render(
            '/admin/colecoes.html.twig',
            ['colecoes' => $app['colecao.repository']->findBy([], ['nome' => 'ASC'])]
        );
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function novo(Request $request, Application $app)
    {
        $colecao = new Colecao();
        
        $colecao->setNome($request->get('nome'));
        $colecao->setDescricao($request->get('descricao'));
        $colecao->setAtivo(true);
        
        $app['colecao.repository']->save($colecao);
        $app['log.controller']->criar('adicionou nova coleção '.$colecao->getNome());
        $app['session']->getFlashBag()->add('mensagem', 'Coleção adicionada com sucesso.');

        if ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
            return $app->redirect('/user/colecoes');
        }

        return $app->redirect('/admin/colecoes/grid');
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editar(Request $request, Application $app)
    {
        /**
         * @var Colecao $colecao
         */
        $colecao = $app['colecao.repository']->find($request->get('id'));

        $colecao->setNome($request->get('nome'));
        $colecao->setDescricao($request->get('descricao'));
        
        $app['colecao.repository']->save($colecao);
        $app['log.controller']->criar('editou a coleção '.$colecao->getNome());
        $app['session']->getFlashBag()->add('mensagem', 'Coleção editada com sucesso.');

        if ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
            return $app->redirect('/user/colecoes');
        }
        
        return $app->redirect('/admin/colecoes/grid');
    }
    
    /**
     * @param $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function alteraStatus($id, Application $app)
    {
        $colecao = $app['colecao.repository']->find($id);
        
        if ($colecao->isAtivo()) {
            $colecao->setAtivo(false);
        } else {
            $colecao->setAtivo(true);
        }
        
        $app['colecao.repository']->save($colecao);
        $app['log.controller']->criar('alterou a situação da Coleção '.$colecao->getNome());
        $app['session']->getFlashBag()->add('mensagem', 'Situação da Coleção alterada com sucesso.');

        if ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
            return $app->redirect('/user/colecoes');
        }
        
        return $app->redirect('/admin/colecoes/grid');
    }
}