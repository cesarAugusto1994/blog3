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
        $colecoes = $app['colecao.repository']->findBy(['ativo' => true]);
    
        return $app['twig']->render(
            '/user/categorias.html.twig',
            ['categorias' => $app['categoria.repository']->findBy(['colecao' => $colecao, 'ativo' => true], ['nome' => 'ASC']),
            'colecoes' => $colecoes, 'colecao' => $colecao]
        );
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function categoriasGrid(Application $app)
    {
        $colecoes = $app['colecao.repository']->findBy(['ativo' => true]);
        $categorias = $app['categoria.repository']->findBy([], ['nome' => 'ASC']);

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
        $categorias = $app['categoria.repository']->findBy(['colecao' => $colecao], ['nome' => 'ASC']);
        
        return $app['twig']->render('admin/categorias.html.twig', ['categorias' => $categorias, 'colecoes' => $colecoes, 'colecao' => $colecao]);
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function novo(Request $request, Application $app)
    {
        try {

            if (empty($request->get('nome'))) {
                throw new \Exception('O nome da Categoria nao foi informado.');
            }

            if (empty($request->get('colecao'))) {
                throw new \Exception('Colecao nao foi informada.');
            }

            $categoria = new Categoria();
            $colecao = $app['colecao.repository']->find($request->get('colecao'));

            $categoria->setNome($request->get('nome'));
            $categoria->setColecao($colecao);
            $categoria->setAtivo(true);

            $app['db']->beginTransaction();
            $app['categoria.repository']->save($categoria);
            $app['db']->commit();

            return $app->json([
                    'classe' => 'sucesso',
                    'mensagem' => 'Adicionou nova categoria ' . $categoria->getNome()
            ]);

        } catch (\Exception $e) {
            return $app->json([
                'classe' => 'erro',
                'mensagem' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editar(Request $request, Application $app)
    {
        /**
         * @var Categoria $categoria
         */
        $categoria = $app['categoria.repository']->find($request->get('id'));
        $colecao = $app['colecao.repository']->find($request->get('colecao'));

        $categoria->setColecao($colecao);
        $categoria->setNome($request->get('nome'));

        $app['db']->beginTransaction();
        $app['categoria.repository']->save($categoria);
        $app['db']->commit();
    
        return $app->json(
            [
                'class' => 'success',
                'message' => 'Categoria '.$categoria->getNome().' editada com sucesso.'
            ]
        );
    }
    
    /**
     * @param int $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function alteraStatus($id, Application $app)
    {
        /**
         * @var Categoria $categoria
         */
        $categoria = $app['categoria.repository']->find($id);

        if ($categoria->isAtivo()) {
            $categoria->setAtivo(false);
        } else {
            $categoria->setAtivo(true);
        }

        $app['db']->beginTransaction();
        $app['categoria.repository']->save($categoria);
        $app['db']->commit();
    
        $mensagem = 'Situação da Categoria  ' . $categoria->getNome() . ' alterada para ' .($categoria->isAtivo() ? 'ativa' : 'inativa'). ' com sucesso.';
        
        $app['log.controller']->criar($mensagem);
        $app['session']->getFlashBag()->add('mensagem', $mensagem);
    
        return $app->json(
            [
                'class' => 'success',
                'message' => $mensagem
            ]
        );
    }
}