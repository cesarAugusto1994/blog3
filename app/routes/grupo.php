<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 25/04/17
 * Time: 16:28
 */

use Api\Entities\EmailEnviado;
use Api\Entities\Grupo;
use Api\Entities\GrupoUsuarios;
use Api\Entities\Usuarios;
use Api\Services\Email;
use Symfony\Component\HttpFoundation\Request;

$grupo = $app['controllers_factory'];

$grupo->get('/', function () use ($app) {

    $grupos = $app['grupo.repository']->findBy([], [], null, 1);

    $grupoUsuarios = $app['grupo.usuarios.repository']->findBy(['usuario' => $app['usuario']]);

    $array = array_map(function($gUser) {
        return $gUser->getGrupo()->getId();
    }, $grupoUsuarios);

    return $app['twig']->render('grupo/index.html.twig',
        [
            'grupos' => $grupos,
            'usuario' => $app['usuario'],
            'gruposUsuario' => $array,
        ]);

})->bind('grupo');


$grupo->get('/convidar', function (Request $request) use ($app) {

    if (!$request->get('grupo')) {
       return $app->redirect('/user/grupos');
    }

    $usuarios = $app['usuarios.repository']->findAll();

    $grupo = $app['grupo.repository']->find($request->get('grupo'));
    return $app['twig']->render('grupo/convidar.html.twig', ['grupo' => $grupo, 'usuario' => $app['usuario'], 'usuarios' => $usuarios]);

})->bind('convidar');

$grupo->post('/convidar', function (Request $request) use ($app) {

    /**
     * @var Usuarios $user
     */
    $user = $app['usuarios.repository']->findOneBy(['email' => $request->request->get('user')]);
    $userEmail = $app['usuarios.repository']->findOneBy(['email' => $request->request->get('email')]);

    $nomeUsuario = "";

    if ($userEmail) {
        $nomeUsuario = $userEmail->getNome();
        $user = $userEmail;
    }

    $config = $app['config'];
    $assunto = "Convite";
    $mensagem = $request->request->get('mensagem');

    $array = [
        'mensagem' => $mensagem,
        'nome' => $nomeUsuario,
        'site' => $config->getNome(),
        'lema' => $config->getSubtitulo()
    ];

    $body = $app['twig']->render('/user/success.html.twig', $array);
    $email = new Email($assunto, $app['email.padrao'], $body);
    $email->send($request->request->get('email'), $app);

    $emailEnviado = new EmailEnviado();
    $emailEnviado->setUsuario($user);
    $emailEnviado->setTipo($assunto);
    $emailEnviado->setMensagem($mensagem);
    $emailEnviado->setDataHora(new DateTime('now'));

    $app['db']->beginTransaction();
    $app['email.enviado.repository']->save($emailEnviado);
    $app['db']->commit();

    $grupo = $app['grupo.repository']->find($request->get('grupo'));

    $app['session']->getFlashBag()->add('mensagem', 'E-mail enviado.');

    return $app->redirect('/user/grupo/' . $grupo->getId() . '-' . urlencode(strtolower($grupo->getNome())));

})->bind('convidar_save');

$grupo->get('/add-repertorio/grupo/{id}-{nome}', function ($id, $nome, Request $request) use ($app) {

    $musicas = [];
    $musicaAnexos = [];
    $posts = [];

    $qRequest = "";
    $tomRequest = "";
    $categoriaRequest = "";
    $colecaoRequest = "";

    if ($request->get('go')) {

        $musicas = $app['musica.repository']->search(
            $request->get('q'),
            $request->get('categoria'),
            $request->get('colecao'),
            $request->get('tom'));

        if ($request->get('q')) {
            $musicaAnexos = $app['musica.anexos.repository']->search($request->get('q'));
            $posts = $app['posts.repository']->search($request->get('q'));
        }

        $qRequest = $request->get('q');
        $tomRequest = $request->get('tom');
        $categoriaRequest = $request->get('categoria');
        $colecaoRequest = $request->get('colecao');

    }

    $colecoes = $app['colecao.repository']->findBy(['ativo' => true]);
    $categorias = $app['categorias'];
    $tons = $app['tonalidades'];

    $grupo = $app['grupo.repository']->find($id);

    $grupoMusicas = $app['grupo.musicas.repository']->findBy(['grupo' => $grupo]);

    $musicasGrupo = array_map(function ($grupoMusica) {
        return $grupoMusica->getMusica()->getId();
    }, $grupoMusicas);

    return $app['twig']->render(
        'grupo/lista-musicas.html.twig',
        [
            'musicas' => $musicas,
            'musica_anexos' => $musicaAnexos,
            'posts' => $posts,
            'tons' => $tons,
            'colecoes' => $colecoes,
            'categoriasColecoes' => $categorias,
            'qRequest' => $qRequest,
            'tomRequest' => $tomRequest,
            'categoriaRequest' => $categoriaRequest,
            'colecaoRequest' => $colecaoRequest,
            'grupo' => $grupo,
            'musicasGrupo' => $musicasGrupo
        ]
    );

})->bind('grupo_add_repertorio');

$grupo->get('/request', function (Request $request) use ($app) {

    if ($request->get('leave')) {

        /**
         * @var Usuarios $usuario
         */
        $usuario = $app['usuarios.repository']->find($request->get('user'));
        $grupo = $app['grupo.repository']->find($request->get('grupo'));
        $grupoUsuarios = $app['grupo.usuarios.repository']->findOneBy(['usuario' => $usuario, 'grupo' => $grupo]);

        $app['db']->beginTransaction();
        $app['grupo.usuarios.repository']->remove($grupoUsuarios);
        $app['db']->commit();

        $app['session']->getFlashBag()->add('mensagem', 'Você saiu do grupo.');

        return $app->redirect('/user/grupos/');
    }

    /**
     * @var Usuarios $usuario
     */
    $usuario = $app['usuarios.repository']->find($request->get('user'));
    $grupo = $app['grupo.repository']->find($request->get('grupo'));

    $grupoUsuarios = new GrupoUsuarios();
    $grupoUsuarios->setGrupo($grupo);
    $grupoUsuarios->setUsuario($usuario);

    $app['db']->beginTransaction();
    $app['grupo.usuarios.repository']->save($grupoUsuarios);
    $app['db']->commit();

    $app['session']->getFlashBag()->add('mensagem', 'Você entrou no grupo ' . $grupo->getNome() . '.');

    return $app->redirect('/user/grupos/');

})->bind('grupo_request');


$grupo->get('/new', function () use ($app) {

    return $app['twig']->render('grupo/novo.html.twig', ['usuario' => $app['usuario']]);

})->bind('gl_add');


$grupo->post('/new-save', function (Request $request) use ($app) {

    $grupo = new Grupo();

    $nome = $request->request->get('grupo') . ' - ' . $request->request->get('cidade') . ' - ' . $request->request->get('estado');

    $grupo->setNome($nome);
    $grupo->setCidade($request->request->get('cidade'));
    $grupo->setUf($request->request->get('estado'));

    $app['db']->beginTransaction();
    $app['grupo.repository']->save($grupo);
    $app['db']->commit();

    /**
     * @var Usuarios $usuario
     */
    $usuario = $app['usuario'];
    $usuario->setGrupo($grupo);

    $app['db']->beginTransaction();
    $app['usuarios.repository']->save($usuario);
    $app['db']->commit();

    return $app->redirect('/user/grupos');

})->bind('gl_save');


return $grupo;