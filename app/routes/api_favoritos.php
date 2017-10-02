<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 02/02/17
 * Time: 13:41
 */

use Api\Entities\Favoritos;
use Symfony\Component\HttpFoundation\Request;

$favoritos = $app['controllers_factory'];

$favoritos->get('favorites/praise/{id}', function($id) use ($app) {

    $userSession = $app['session']->get('user');

    $usuario = $app['usuarios.repository']->find($userSession->getId());
    $musica = $app['musica.repository']->find($id);

    $favorito = $app['favoritos.repository']->findBy(['usuario' => $usuario,'musica' => $musica]);

    return new \Symfony\Component\HttpFoundation\JsonResponse($favorito);

})->bind('api_favorites');

$favoritos->get('favorites', function() use ($app) {

    $userSession = $app['session']->get('user');
    $usuario = $app['usuarios.repository']->find($userSession->getId());

    $favorito = $app['favoritos.repository']->findBy(['usuario' => $usuario]);

    return new \Symfony\Component\HttpFoundation\JsonResponse($favorito);

})->bind('api_user_favorites');

$favoritos->get('/user/{id}/my-favorites', function($id) use ($app) {

    $usuario = $app['usuarios.repository']->find($id);

    $favoritos = $app['favoritos.repository']->findBy(['usuario' => $usuario]);

    return new \Symfony\Component\HttpFoundation\JsonResponse($favoritos);

})->bind('api_user_fav');

$favoritos->post('favoritos/add-remove', function (Request $request) use ($app) {

    try {

        if (0 == $request->request->count()) {
            throw new Exception('Request vazio.');
        }

        if (empty($request->request->get('id'))) {
            throw new Exception('Id Request vazio.');
        }

        $musica = $app['musica.repository']->find($request->request->get('id'));

        $favorito = $app['favoritos.repository']->findOneBy(['usuario' => $app['usuario'], 'musica' => $musica]);

        if (empty($favorito)) {

            $fav = new Favoritos();
            $fav->setMusica($musica);
            $fav->setUsuario($app['usuario']);
            $fav->setCadastro(new DateTime('now'));

            $app['db']->beginTransaction();
            $app['favoritos.repository']->save($fav);
            $app['db']->commit();

            return $app->json([
                'classe' => 'sucesso',
                'bln' => true,
                'mensagem' => $musica->getNome() . ' foi adicionada aos seus favoritos.',
            ]);

        }

        $app['db']->beginTransaction();
        $app['favoritos.repository']->remove($favorito);
        $app['db']->commit();

        return $app->json([
            'classe' => 'sucesso',
            'bln' => false,
            'mensagem' => $musica->getNome() . ' foi removido aos seus favoritos.',
        ]);
    } catch (Exception $e) {
        return $app->json([
            'classe' => 'erro',
            'bln' => true,
            'mensagem' => $e->getMessage()
        ]);
    }

});

return $favoritos;