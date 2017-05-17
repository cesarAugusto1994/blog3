<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 08:41
 */

use Api\Entities\Categoria;
use Api\Entities\Musica;
use Api\Entities\Usuarios;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$musica = $app['controllers_factory'];

$musica->get('musicas/{id}', function($id) use ($app) {
    $musica = $app['musica.repository']->find($id);
    return new \Symfony\Component\HttpFoundation\JsonResponse($musica);
})->bind('api_musica');

$musica->get('praise-success', function() use ($app) {
    return $app['twig']->render('/user/musica-sucesso.html.twig');;
})->bind('praise_success');

$musica->get('praise/{id}-{nome}/fullscreen', function($id, $nome) use ($app) {
    $musica = $app['musica.repository']->find($id);
    return $app['twig']->render('/user/view.html.twig', ['musica' => $musica]);
})->bind('musica_view');


$musica->get('musicas/adicionadas/recentemente', function() use ($app) {

    if (!empty($app['session']->get('musicas_adicionadas'))) {
        return new \Symfony\Component\HttpFoundation\JsonResponse($app['session']->get('musicas_adicionadas'));
    }

    $musicas = $app['musica.repository']->findBy(['ativo' => true], ['cadastro' => 'DESC'], 10);
    $app['session']->set('musicas_adicionadas', $musicas);

    return new \Symfony\Component\HttpFoundation\JsonResponse($musicas);


})->bind('api_musicas_recentes');


$musica->get('musicas/{categoria}/data', function($categoria) use ($app) {
    $categoria = $app['categoria.repository']->find($categoria);

    $paremetros = [
        'categoria' => $categoria,
        'ativo' => true
    ];

    if ("ROLE_ADMIN" == $app["usuario"]->getRoles()) {
        array_pop($paremetros);
    }

    $musicas = $app['musica.repository']->findBy($paremetros, ['numero' => 'ASC', 'nome' => 'ASC']);
    return new \Symfony\Component\HttpFoundation\JsonResponse($musicas);
})->bind('api_musicas');

$musica->get('musicas/{categoriaId}/{nome}', function($categoriaId, $nome) use ($app) {

    $categoria = $app['categoria.repository']->find($categoriaId);
    $musicas = $app['musica.repository']->findBy(['categoria' => $categoria, 'ativo' => true], ['numero' => 'ASC', 'nome' => 'ASC']);

    return $app['twig']->render('/user/musicas.html.twig', ['musicas' => $musicas, 'categoria' => $categoria]);

})->bind('view_musicas');

$musica->get('musica/adicionar/{categoria}', function($categoria) use ($app){

    return $app['twig']->render('/user/musica-adicionar.html.twig', ['categoria' => $categoria]);

})->bind('view_adicionar_musica_');

$musica->get('praise/new', function(\Symfony\Component\HttpFoundation\Request $request) use ($app){

    $categoria = ["id" => 0, "nome" => "categoria"];

    if ($request->get('category_id')) {
        $categoria = $app['categoria.repository']->find($request->get('category_id'));
    }

    if ($request->get('same_category')) {
        return $app['twig']->render('/user/musica-adicionar-mesma-categoria.html.twig', ['categoria' => $categoria]);
    }

    if ($request->get('various')) {
        return $app['twig']->render('/user/musica-adicionar-2.html.twig', ['categoria' => $categoria]);
    }

    return $app['twig']->render('/user/musica-adicionar.html.twig',
        [
            'categoriaSelecionada' => $categoria,
            'tons' => $app['tonalidades'],
            'colecoes' => $app['categorias'],
            'mensagem' => '',
            'nome' => '',
            'numero' => '',
            'tonalidade' => '',
            'categoria' => '',
            'letra' => '',
        ]);

});

$musica->get('musicas/adicionar/{categoria}/1', function($categoria) use ($app){

    $categorias = $app['categoria.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);
    return $app['twig']->render(
        '/user/musica_nova.html.twig',
        ['categoriaTela' => $categoria, 'categorias' => $categorias]
    );

})->bind('view_adicionar_musica');

$musica->get('praises/{id}-{nome}/edit', function($id, $nome) use ($app){

    $musica = $app['musica.repository']->find($id);
    $categorias = $app['categoria.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);

    $array = [];
    /**
     * @var Categoria $categoria
     */
    foreach ($categorias as $categoria) {

        $key = $categoria->getColecao()->getId();

        if (!isset($array[$key]['nome'])) {
            $array[$key]['nome'] = $categoria->getColecao()->getNome();
        }

        if ($categoria->getColecao()->getNome() == $array[$key]['nome']) {

            $array[$key]['nome'] = $categoria->getColecao()->getNome();

            $array[$key]['categorias'][] = [
                "id" => $categoria->getId(),
                "nome" => $categoria->getNome()
            ];
        }
    }

    return $app['twig']->render('/user/musica_editar.html.twig', ['musica' => $musica, 'categorias' => array_merge($array)]);

})->bind('view_editar_musica');

$musica->get('musicas/{id}/letra/editar/view', function($id) use ($app){

    $musica = $app['musica.repository']->find($id);
    $categorias = $app['categoria.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);
    return $app['twig']->render(
        '/user/musica_editar_letra.html.twig',
        ['musica' => $musica, 'categorias' => $categorias]
    );

})->bind('view_editar_letra_musica');

$musica->get('tonalidades', function () use ($app) {
    return new \Symfony\Component\HttpFoundation\JsonResponse($app['tonalidades']);
});

$musica->post('musicas/{id}/status', function($id) use ($app){

    /**
     * @var \Api\Entities\Musica $musica
     */
    $musica = $app['musica.repository']->find($id);
    $musica->setAtivo(!$musica->isAtivo());

    $app['db']->beginTransaction();
    $app['musica.repository']->save($musica);
    $app['db']->commit();

    return $app->json([
        'class' => 'success',
        'message' => 'O item foi '. ($musica->isAtivo() ? 'ativado' : 'inativado') . ' com sucesso'
    ]);
    
})->bind('api_musica_status');

$app->post('musica/{id}/letra/editar', function($id, \Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    /**
     * @var \Api\Entities\Musica $musica
     */
    $musica = $app['musica.repository']->find($id);
    
    if (!$musica) {
        throw new Exception('Musica não encontrada.');
    }

    $encontrarVirgula = [
        'Ab,', 'Abm,', 'A,', 'Am,', 'A#,', 'A#m,',
        'Ab7,', 'Abm7,', 'A7,', 'Am7,', 'A#7,', 'A#m7,',
        'Bb,', 'Bbm,', 'B,', 'Bm,',
        'Bb7,', 'Bbm7,', 'B7,', 'Bm7,',
        'C,', 'Cm,', 'C#,', 'C#m,',
        'C7,', 'Cm7,', 'C#7,', 'C#m7,',
        'C9,', 'Cm9,', 'C#9,', 'C#m9,',
        'Db,', 'Dbm,', 'D,', 'Dm,', 'D#,', 'D#m,',
        'Db7,', 'Dbm7,', 'D7,', 'Dm7,', 'D#7,', 'D#m7,',
        'Eb,', 'Ebm,', 'E,', 'Em,',
        'Eb7,', 'Ebm7,', 'E7,', 'Em7,',
        'F,', 'Fm,', 'F#,', 'F#m,',
        'F7,', 'Fm7,', 'F#7,', 'F#m7,',
        'Gb,', 'Gbm,', 'G,', 'Gm,', 'G#,', 'G#m,',
        'Gb7,', 'Gbm7,', 'G7,', 'Gm7,', 'G#7,', 'G#m7,'
    ];

    $removerVirgulas = [
        'Ab ', 'Abm ', 'A ', 'Am ', 'A# ', 'A#m ',
        'Ab7 ', 'Abm7 ', 'A7 ', 'Am7 ', 'A#7 ', 'A#m7 ',
        'Bb ', 'Bbm ', 'B ', 'Bm ',
        'Bb7 ', 'Bbm7 ', 'B7 ', 'Bm7 ',
        'C ', 'Cm ', 'C# ', 'C#m ',
        'C7 ', 'Cm7 ', 'C#7 ', 'C#m7 ',
        'C9 ', 'Cm9 ', 'C#9 ', 'C#m9 ',
        'Db ', 'Dbm ', 'D ', 'Dm ', 'D# ', 'D#m ',
        'Db7 ', 'Dbm7 ', 'D7 ', 'Dm7 ', 'D#7 ', 'D#m7 ',
        'Eb ', 'Ebm ', 'E ', 'Em ',
        'Eb7 ', 'Ebm7 ', 'E7 ', 'Em7 ',
        'F ', 'Fm ', 'F# ', 'F#m ',
        'F7 ', 'Fm7 ', 'F#7 ', 'F#m7 ',
        'Gb ', 'Gbm ', 'G ', 'Gm ', 'G# ', 'G#m ',
        'Gb7 ', 'Gbm7 ', 'G7 ', 'Gm7 ', 'G#7 ', 'G#m7 '
    ];

    $search = ['7M', '4', '(4)', '(sus)', '(9)', '(b9)', 'º', '(#5)', 'Introdução: ', 'Instrumentos '];
    $replace = ['maj7', 'sus', 'sus', 'sus', '9', 'b9', 'dim', '#5', "Introdução: \n", "Instrumentos \n"];

    $search = array_merge($search, $encontrarVirgula);
    $replace = array_merge($replace, $removerVirgulas);

    $letra = str_replace($search, $replace, $request->get('letra'));
    $musica->setLetra(strip_tags($letra));
    $musica->setLetraOriginal($letra);
    
    $app['db']->beginTransaction();
    $app['musica.repository']->save($musica);
    $app['db']->commit();
    
    return $app->redirect('/user/praise/'.$musica->getId().'-'.$musica->getId());
    
})->bind('api_musica_letra_editar');

$musica->post('/musica/add', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    try {

        if (0 == $request->request->count()) {
            throw new \InvalidArgumentException("Nao foi possivel adicionar esta m&uacute;sica: Nenhum dado foi informado.");
        }

        if (empty($request->get('categoria'))) {
            throw new \Exception("Não foi possivel Adicionar musica: A Categoria nao foi informada.");
        }

        $categoria = $app['categoria.repository']->find($request->get('categoria'));
        $musicaJaExisteNaCategoria = $app['musica.repository']->findBy(
            [
                'nome' => $request->get('nome'),
                'categoria' => $categoria,
            ]
        );

        if ($musicaJaExisteNaCategoria) {
            throw new \Exception("Não foi poss&iacute;vel adicionar m&uacute;sica: M&uacute;sica já adiconada.");
        }

        if (empty($request->get('nome'))) {
            throw new \Exception("Não foi possivel Adicionar musica: O nome nao foi informado.");
        }

        /**
         * @var \Api\Entities\Categoria $categoria
         */
        $categoria = $app['categoria.repository']->find($request->get('categoria'));
        $user = $app['session']->get('user');
        /**
         * @var \Api\Entities\Usuarios $usuario
         */
        $usuario = $app['usuarios.repository']->find($user->getId());

        $musica = new Musica();

        $musica->setNome(strtoupper($request->get('nome')));
        $musica->setNumero($request->get('numero') ?: null);
        $musica->setTom($request->get('tonalidade'));

        if ($request->get('album')) {
            $album = $app['album.repository']->find($request->get('album'));
            $musica->setAlbum($album);
        }

        if ($request->get('letra')) {

            $encontrarVirgula = [
                'Ab,', 'Abm,', 'A,', 'Am,', 'A#,', 'A#m,',
                'Ab7,', 'Abm7,', 'A7,', 'Am7,', 'A#7,', 'A#m7,',
                'Bb,', 'Bbm,', 'B,', 'Bm,',
                'Bb7,', 'Bbm7,', 'B7,', 'Bm7,',
                'C,', 'Cm,', 'C#,', 'C#m,',
                'C7,', 'Cm7,', 'C#7,', 'C#m7,',
                'C9,', 'Cm9,', 'C#9,', 'C#m9,',
                'Db,', 'Dbm,', 'D,', 'Dm,', 'D#,', 'D#m,',
                'Db7,', 'Dbm7,', 'D7,', 'Dm7,', 'D#7,', 'D#m7,',
                'Eb,', 'Ebm,', 'E,', 'Em,',
                'Eb7,', 'Ebm7,', 'E7,', 'Em7,',
                'F,', 'Fm,', 'F#,', 'F#m,',
                'F7,', 'Fm7,', 'F#7,', 'F#m7,',
                'Gb,', 'Gbm,', 'G,', 'Gm,', 'G#,', 'G#m,',
                'Gb7,', 'Gbm7,', 'G7,', 'Gm7,', 'G#7,', 'G#m7,'
            ];

            $removerVirgulas = [
                'Ab ', 'Abm ', 'A ', 'Am ', 'A# ', 'A#m ',
                'Ab7 ', 'Abm7 ', 'A7 ', 'Am7 ', 'A#7 ', 'A#m7 ',
                'Bb ', 'Bbm ', 'B ', 'Bm ',
                'Bb7 ', 'Bbm7 ', 'B7 ', 'Bm7 ',
                'C ', 'Cm ', 'C# ', 'C#m ',
                'C7 ', 'Cm7 ', 'C#7 ', 'C#m7 ',
                'C9 ', 'Cm9 ', 'C#9 ', 'C#m9 ',
                'Db ', 'Dbm ', 'D ', 'Dm ', 'D# ', 'D#m ',
                'Db7 ', 'Dbm7 ', 'D7 ', 'Dm7 ', 'D#7 ', 'D#m7 ',
                'Eb ', 'Ebm ', 'E ', 'Em ',
                'Eb7 ', 'Ebm7 ', 'E7 ', 'Em7 ',
                'F ', 'Fm ', 'F# ', 'F#m ',
                'F7 ', 'Fm7 ', 'F#7 ', 'F#m7 ',
                'Gb ', 'Gbm ', 'G ', 'Gm ', 'G# ', 'G#m ',
                'Gb7 ', 'Gbm7 ', 'G7 ', 'Gm7 ', 'G#7 ', 'G#m7 '
            ];

            $search = ['7M', '4', '(9)', 'º', '(#5)', 'Introdução: ', 'Instrumentos '];
            $replace = ['maj7', 'sus', '9', 'dim', '#5', "Introdução: \n", "Instrumentos \n"];

            $search = array_merge($search, $encontrarVirgula);
            $replace = array_merge($replace, $removerVirgulas);

            $letra = str_replace($search, $replace, $request->get('letra'));
            $musica->setLetra(strip_tags(htmlspecialchars_decode($letra)));
            $musica->setLetraOriginal($letra);
        }

        $musica->setCategoria($categoria);
        $musica->setUsuario($usuario);
        $musica->setCadastro(new \DateTime('now'));
        $musica->setNovo(false);

        if ($request->get('novo')) {
            $musica->setNovo($request->get('novo'));
        }

        $ativo = false;

        if (Usuarios::ROLE_ADMIN == $usuario->getRoles()) {
            $ativo = true;
        }

        $musica->setAtivo($ativo);

        $app['db']->beginTransaction();
        $app['musica.repository']->save($musica);
        $app['db']->commit();

        $app['session']->getFlashBag()->add('mensagem', 'Musica adicionada com sucesso.');

        return $app->redirect('/user/category/'. $musica->getCategoria()->getId().'-'.urlencode(strtolower(trim($musica->getCategoria()->getNome()))));

    } catch (Exception $e) {

        if ($request->request->get('categoria')) {
            $categoria = $app['categoria.repository']->find($request->request->get('categoria'));
        }

        return $app['twig']->render('/user/musica-adicionar.html.twig',
            [
                'categoriaSelecionada' => $categoria,
                'tons' => $app['tonalidades'],
                'colecoes' => $app['categorias'],
                'mensagem' => $e->getMessage(),
                'nome' => $request->request->get('nome'),
                'numero' => $request->request->get('numero'),
                'tonalidade' => $request->request->get('tonalidade'),
                'categoria' => $request->request->get('categoria'),
                'letra' => $request->request->get('letra'),
            ]);

    }
})->bind('musica_adicionar');


$musica->post('musica/editar', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    /**
     * @var \Api\Entities\Musica $musica
     */
    $musica = $app['musica.repository']->find($request->get('id'));

    if ($request->get('nome')) {
        $musica->setNome($request->get('nome'));
    }

    $musica->setNumero($request->get('numero') ?: null);

    if ($request->get('tonalidade')) {
        $musica->setTom($request->get('tonalidade'));
    }

    if ($request->get('letra')) {
        $musica->setLetra(strip_tags($request->get('letra')));
        $musica->setLetraOriginal($request->get('letra'));
    }

    if ($request->get('categoria')) {
        /**
         * @var \Api\Entities\Categoria $categoria
         */
        $categoria = $app['categoria.repository']->find($request->get('categoria'));
        $musica->setCategoria($categoria);
    }

    $app['db']->beginTransaction();
    $app['musica.repository']->save($musica);
    $app['db']->commit();

    return $app->redirect('/user/praise/'.$musica->getId().'-'.$musica->getId());

})->bind('save_musica');


$musica->get('/praise/{id}-{nome}/arquivos', function($id, $nome) use ($app) {

    $musica = $app['musica.repository']->find($id);
    $anexos = $app['musica.anexos.repository']->findBy(['musica' => $musica, 'ativo' => true], ['nome' => 'ASC']);
    $tipo = $app['tipo.anexo.repository']->find(1);
    $tipos = $app['tipo.anexo.repository']->findAll();
    $musicas = $app['musica.anexos.repository']->findBy(['musica' => $musica, 'tipo' => $tipo, 'ativo' => true], ['nome' => 'ASC']);

    return $app['twig']->render('/user/musica/anexos.html.twig',
        [
            'anexos' => $anexos,
            'tipos' => $tipos,
            'musica' => $musica,
            'musicas' => $musicas
        ]);

})->bind('app_attachments_from_praise');

$musica->get('/praise/create/from/file', function (Request $request) use ($app) {

    try {

        exit('Nunca executar essa rota');

        $file = file(__DIR__ . '/../../web/assets/blog/export/coletanea.csv');

        foreach ($file as $key => $dado) {

            $col = explode(";", $dado);

            if (empty($col[0]) || empty($col[1])) {
                continue;
            }

            $musica = $app['musica.repository']->findOneBy(['numero' => $col[1]]);

            if ($musica) {
                continue;
            }

            $categoria = 0;

            if (3 == strlen(trim($col[1]))) {

                $categoria = 11;

            } elseif (4 == strlen(trim($col[1]))) {

                $s = substr((int)trim($col[1]), 0, 1);

                switch ($s) {
                    case 1 :
                        $categoria = 12;
                        break;
                    case 2 :
                        $categoria = 10;
                        break;
                    case 3 :
                        $categoria = 13;
                        break;
                    case 4 :
                        $categoria = 14;
                        break;
                    case 5 :
                        $categoria = 15;
                        break;
                    case 6 :
                        $categoria = 16;
                        break;
                    case 7 :
                        if ($col[1] >= 7750 && $col[1] < 7899) {
                            $categoria = 45;
                        } else {
                            $categoria = 17;
                        }
                        break;
                    case 8 :
                        $categoria = 18;
                        break;
                    case 9 :
                        $categoria = 19;
                        break;
                }
            }

            $categoriaEntity = $app['categoria.repository']->find($categoria);

            $encoding = 'UTF-8'; // ou ISO-8859-1...
            $nome = mb_convert_case($col[0], MB_CASE_UPPER, $encoding);

            $musica = new Musica();
            $musica->setNome((strtoupper(trim($nome))));
            $musica->setNumero(trim($col[1]));
            $musica->setCategoria($categoriaEntity);
            $musica->setTom("C");
            $musica->setUsuario($app['usuario']);
            $musica->setCadastro(new DateTime('now'));
            $musica->setAtivo(true);
            $musica->setNovo(false);
            $musica->setApenasAnexos(false);

            $app['db']->beginTransaction();
            $app['musica.repository']->save($musica);
            $app['db']->commit();

        }

    } catch (Exception $e) {
        echo $e->getMessage();
    }

    return new Response('Musicas Adicionadas');

})->bind('app_create_praise_from_file');

return $musica;