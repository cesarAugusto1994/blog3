<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:31
 */

$colecao = $app['controllers_factory'];

$colecao->get('collections', function() use ($app){

    return $app['twig']->render(
        '/user/colecoes.html.twig',
        ['colecoes' => $app['colecao.repository']->findBy([], ['nome' => 'ASC'])]
    );

})->bind('colecoes');

$colecao->get('/collection/{id}-{nome}', function ($id, $nome) use ($app) {

    $colecao = $app['colecao.repository']->find($id);
    $categorias = $app['categoria.repository']->findBy(['colecao' => $colecao, 'ativo' => true], ['nome' => 'ASC']);

    return $app['twig']->render(
        '/user/categorias.html.twig',
        ['categorias' => $categorias, 'colecao' => $colecao]
    );
})->bind('view_collection');

$colecao->get('colecao/{colecao}', function($colecao) use ($app){

    $colecao = $app['colecao.repository']->find($colecao);
    return new \Symfony\Component\HttpFoundation\JsonResponse($colecao);

})->bind('api_colecao');

$colecao->get('colecoes/grid', function() use ($app){

    return $app['twig']->render(
        '/admin/colecoes.html.twig',
        ['colecoes' => $app['colecao.repository']->findBy([], ['nome' => 'ASC'])]
    );

})->bind('colecoes_grid');

$colecao->get('/colecao/{id}-{nome}/editar', function ($id, $nome) use ($app) {

    $colecao = $app['colecao.repository']->find($id);
    return $app['twig']->render('/user/colecao/editar.html.twig', ['colecao' => $colecao]);

})->bind('colecao_editar');

$colecao->post('colecao/save', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    if ($request->get('id')) {

        /**
         * @var \Api\Entities\Colecao $colecao
         */
        $colecao = $app['colecao.repository']->find($request->get('id'));

        $colecao->setNome($request->get('nome'));
        $colecao->setDescricao($request->get('descricao'));

        if (!empty($_FILES['background']['size'])) {
            $colecao->setImagem($app['upload.service']->upload($_FILES['background'], 'colecao', $colecao->getImagem()));
            $app['log.controller']->criar('alterou a imagem de fundo da cole&ccedil;&atilde;o '.$colecao->getNome());
        }

        $app['db']->beginTransaction();
        $app['colecao.repository']->save($colecao);
        $app['db']->commit();

        $app['session']->getFlashBag()->add('mensagem', 'Coleção '.$colecao->getNome().' editada com sucesso.');

        return $app->redirect('/user/collections');

    }
    
    $colecao = new \Api\Entities\Colecao();

    $colecao->setNome($request->get('nome'));
    $colecao->setDescricao($request->get('descricao'));
    $colecao->setAtivo(true);

    $app['db']->beginTransaction();
    $app['colecao.repository']->save($colecao);
    $app['db']->commit();

    return $app->redirect('/user/colecoes');
    
})->bind('save_colecao');

$colecao->post('colecao/{id}/status', function($id) use ($app) {

    /**
     * @var \Api\Entities\Colecao $colecao
     */
    $colecao = $app['colecao.repository']->find($id);
    $colecao->setAtivo(!$colecao->isAtivo());

    $app['db']->beginTransaction();
    $app['colecao.repository']->save($colecao);
    $app['db']->commit();

    $mensagem = 'Situação da Coleção  ' . $colecao->getNome() . ' alterada para ' .($colecao->isAtivo() ? 'ativa' : 'inativa'). ' com sucesso.';

    return $app->json(
        [
            'class' => 'success',
            'message' => $mensagem
        ]
    );

})->bind('colecao_status');

return $colecao;