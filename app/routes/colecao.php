<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:31
 */

$colecao = $app['controllers_factory'];

$colecao->get('colecoes', function() use ($app){

    return $app['twig']->render(
        '/user/colecoes.html.twig',
        ['colecoes' => $app['colecao.repository']->findBy([], ['nome' => 'ASC'])]
    );

})->bind('colecoes');

$colecao->get('colecoes/all', function() use ($app){
    $colecoes = $app['colecao.repository']->findBy([], ['nome' => 'ASC']);
    return new \Symfony\Component\HttpFoundation\JsonResponse($colecoes);
})->bind('api_colecoes');

$colecao->get('/admin/colecoes/grid', function() use ($app){

    return $app['twig']->render(
        '/admin/colecoes.html.twig',
        ['colecoes' => $app['colecao.repository']->findBy([], ['nome' => 'ASC'])]
    );

})->bind('colecoes_grid');

$colecao->post('/admin/colecao/save', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
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

        $mensagem = 'Coleção '.$colecao->getNome().' editada com sucesso.';

        return $app->json(
            [
                'class' => 'success',
                'message' => $mensagem
            ]
        );

    }
    
    $colecao = new \Api\Entities\Colecao();

    $colecao->setNome($request->get('nome'));
    $colecao->setDescricao($request->get('descricao'));
    $colecao->setAtivo(true);

    $app['db']->beginTransaction();
    $app['colecao.repository']->save($colecao);
    $app['db']->commit();

    if ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
        return $app->redirect('/user/colecoes');
    }

    return $app->redirect('/admin/colecoes/grid');
    
})->bind('save_colecao');

$colecao->post('colecao/{id}', function($id) use ($app) {

    $colecao = $app['colecao.repository']->find($id);

    if ($colecao->isAtivo()) {
        $colecao->setAtivo(false);
    } else {
        $colecao->setAtivo(true);
    }

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