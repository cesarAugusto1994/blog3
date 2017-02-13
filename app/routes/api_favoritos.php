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

$favoritos->post('favoritos/add-remove', function (Request $request) use ($app) {

    if (0 == $request->request->count()) {
        throw new Exception('Request vazio.');
    }

    if (empty($request->request->get('id'))) {
        throw new Exception('Id Request vazio.');
    }

    $userSession = $app['session']->get('user');

    $usuario = $app['usuarios.repository']->find($userSession->getId());
    $musica = $app['musica.repository']->find($request->request->get('id'));

    $favorito = $app['favoritos.repository']->findBy(['usuario' => $usuario,'musica' => $musica]);

    if (empty($favorito)) {

        $fav = new Favoritos();
        $fav->setMusica($musica);
        $fav->setUsuario($usuario);
        $fav->setCadastro(new DateTime('now'));

        $app['favoritos.repository']->save($fav);

        return $app->json([
            'classe' => 'sucesso',
            'mensagem' =>  $musica->getNome() . ' foi adicionada aos seus favoritos.',
        ]);

    }

    $app['favoritos.repository']->remove($favorito[0]);

    return $app->json([
        'classe' => 'sucesso',
        'mensagem' =>  $musica->getNome() . ' foi removida aos seus favoritos.',
    ]);

});

return $favoritos;