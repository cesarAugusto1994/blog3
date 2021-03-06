<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 26/01/17
 * Time: 09:50
 */

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;

$musica = $app['controllers_factory'];

$musica->get('praise/{id}-{nome}', function($id, $nome) use ($app) {

    $musica = $app['musica.repository']->find($id);
    return new \Symfony\Component\HttpFoundation\JsonResponse($musica);

})->bind('api_praise');

$musica->get('praises', function() use ($app) {

    $paremetros['ativo'] = true;

    $musicas = $app['musica.repository']->findBy($paremetros, ['numero' => 'ASC', 'nome' => 'ASC']);

    $musicas = array_map(function($musica){

        /**
         * @var \Api\Entities\Musica $musica
         */

        return [
            'id' => $musica->getId(),
            'nome' => $musica->getNome(),
            'numero' => $musica->getNumero(),
            'letra' => $musica->getLetra(),
            'tom' => $musica->getTom(),
            'categoria' => $musica->getCategoria()->getId(),
        ];

    }, $musicas);

    return new \Symfony\Component\HttpFoundation\JsonResponse($musicas);

})->bind('api_praises');

$musica->get('/praises/added', function() use ($app) {

    $musica = $app['musica.repository']->findBy(['ativo' => 0]);

    return new \Symfony\Component\HttpFoundation\JsonResponse($musica);

})->bind('api_praises_added');

/**
 *
 */
$musica->post('/musica/adicionar', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    try {

        return $app['musica.controller']->newAction($request);

    } catch (Exception $e) {

        return new JsonResponse([
            "classe" => "error",
            "message" => $e->getMessage(),
        ]);
    }
})->bind('musica_adicionar');


$musica->post('/musica/adicionar/varios', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    try {

        $arrayItens = $request->request->all();

        foreach ($arrayItens as $itens) {

            foreach ($itens as $item) {

                if (empty($item['nome'])) {
                    continue;
                }

                $app['musica.controller']->newFromArrayAction($item);
            }

        }

        return new JsonResponse([
            "classe" => "success",
            "message" => "Itens Cadastrados",
        ], 201);

    } catch (Exception $e) {

        return new JsonResponse([
            "classe" => "error",
            "message" => $e->getMessage(),
        ], 400);
    }
});

return $musica;