<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 08:41
 */

use App\Controllers\Uploader;
use Symfony\Component\BrowserKit\Request;

$anexos = $app['controllers_factory'];

$anexos->get('/praise/{id}-{name}/attachments', function($id, $name) use ($app) {
    /**
     * @var \Api\Entities\Musica $musica
     */
    $musica = $app['musica.repository']->find($id);
    $tipos = $app['tipo.anexo.repository']->findBy(['ativo' => true]);

    return $app['twig']->render(
        '/user/musica_anexos.html.twig',
        [
            'musica' => $musica,
            'tipos' => $tipos,
        ]
    );

})->bind('musica_anexos');

$anexos->get('/musica/{musicaId}/anexos/data', function($musicaId) use ($app) {

    $musica = $app['musica.repository']->find($musicaId);
    $anexos = $app['musica.anexos.repository']->findBy(['musica' => $musica, 'ativo' => true]);
    return new \Symfony\Component\HttpFoundation\JsonResponse($anexos);

})->bind('api_anexos');

$anexos->get('/musicas/anexos/grid/{musicaId}/{nome}', function($musicaId, $nome) use ($app){

    $musica = $app['musica.repository']->find($musicaId);
    $tipos = $app['tipo.anexo.repository']->findBy(['ativo' => true]);

    return $app['twig']->render(
        'admin/musica_anexos.html.twig',
        [
            'anexos' => $app['musica.anexos.repository']->findBy(['musica' => $musica, 'ativo' => true]),
            'musica' => $musica,
            'tipos' => $tipos
        ]
    );

})->bind('musica_anexos_grid');

$anexos->post('/musica/anexos/{id}/remover', function($id) use ($app) {

    /**
     * @var \Api\Entities\MusicaAnexos $anexo
     */
    $anexo = $app['musica.anexos.repository']->find($id);

    $directory = $app['dir.base2'].'assets/blog/musicas/'.$anexo->getLink();

    if(file_exists($directory)) {
        unlink($directory);
    }

    $app['db']->beginTransaction();
    $app['musica.anexos.repository']->remove($anexo);
    $app['db']->commit();

    $mensagem = 'removeu o arquivo '.$anexo->getNome();

    $app['log.controller']->criar($mensagem);
    $app['session']->getFlashBag()->add('mensagem', $mensagem);

    return $app->json(
        [
            'class' => 'success',
            'message' => $mensagem
        ]
    );
    })->bind('musica_anexos_remover');


$anexos->post('/musica/anexos/remover', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    if (empty($request->request->get('id'))) {
        throw new Exception('Id não informado.');
    }

    /**
     * @var \Api\Entities\MusicaAnexos $anexo
     */
    $anexo = $app['musica.anexos.repository']->find($request->request->get('id'));

    $directory = $app['dir.base2'].'assets/blog/musicas/'.$anexo->getLink();

    if(file_exists($directory)) {
        unlink($directory);
    }

    $app['db']->beginTransaction();
    $app['musica.anexos.repository']->remove($anexo);
    $app['db']->commit();

    $mensagem = 'removeu o arquivo '.$anexo->getNome();

    $app['log.controller']->criar($mensagem);
    $app['session']->getFlashBag()->add('mensagem', $mensagem);

    return $app->json(
        [
            'class' => 'success',
            'message' => $mensagem
        ]
    );
});

$anexos->get('/praise/{id}-{nome}/videos', function ($id, $nome) use ($app) {

    $musica = $app['musica.repository']->find($id);
    $tipo = $app['tipo.anexo.repository']->find(4);
    $videos = $app['musica.anexos.repository']->findBy(['musica' => $musica, 'tipo' => $tipo]);
    return $app['twig']->render('user/musica-videos.html.twig', ['musica' => $musica, 'videos' => $videos]);

})->bind('musica_videos');

$anexos->get('/praise/{id}-{nome}/video/{video}', function ($id, $nome, $video) use ($app) {

    $musica = $app['musica.repository']->find($id);
    $video = $app['musica.anexos.repository']->find($video);
    return $app['twig']->render('user/musica-video.html.twig', ['musica' => $musica, 'video' => $video]);

})->bind('musica_video');

$anexos->get('/musica/anexos/videos', function () use ($app) {

    $tipo = $app['tipo.anexo.repository']->find(4);
    $videos = $app['musica.anexos.repository']->findBy(['tipo' => $tipo]);
    return $app['twig']->render('user/videos.html.twig', ['videos' => $videos]);

})->bind('videos');

$anexos->get('/videos/data', function() use ($app) {
    
    $tipo = $app['tipo.anexo.repository']->find(4);
    $videos = $app['musica.anexos.repository']->findBy(['tipo' => $tipo]);
    return new \Symfony\Component\HttpFoundation\JsonResponse($videos);
    
})->bind('api_videos');

$anexos->get('/comentarios/{musicaId}', function ($musicaId) use ($app) {

    $musica = $app['musica.repository']->find($musicaId);
    $comentarios = $app['comentario.repository']->findBy(['musica' => $musica, 'ativo' => true], ['id' => 'DESC']);
    return new \Symfony\Component\HttpFoundation\JsonResponse($comentarios);

})->bind('api_comentarios');

$anexos->post('/musica/{musicaId}/anexos/upload', function($musicaId, \Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    try {

        if (!$musicaId) {
            throw new Exception('Musica não informada');
        }

        if (!$request->files) {
            throw new Exception('Arquivo não informado');
        }

        $musica = $app['musica.repository']->find($musicaId);
        $user = $app['session']->get('user');
        $usuario = $app['usuarios.repository']->find($user->getId());

        $uploader = new Uploader();
        $data = $uploader->upload(
            $_FILES['files'],
            array(
                'limit' => 100, 'maxSize' => 120, 'extensions' => null, 'required' => false, 'title' => array('name'), 'removeFiles' => true, 'replace' => true,
                'perms' => null, 'onCheck' => null, 'onError' => null, 'onSuccess' => null, 'onUpload' => null, 'onComplete' => true, 'onRemove' => null
            )
        );

        if ($data['hasErrors']) {
            return $app->json(
                [
                    'class' => 'error',
                    'message' => $data['errors']
                ]
            );
        }

        $mensagem = 'Nenhum arquivo foi encontrado.';

        foreach ($_FILES['files']['name'] as $key => $name) {

            if (empty($name)) {
                continue;
            }

            $tipo = $app['tipo.anexo.repository']->find(
                \App\Controllers\MediaFormat::getFormatTipo($_FILES['files']['type'][$key])
            );

            $musicaAnexo = new \Api\Entities\MusicaAnexos();
            $musicaAnexo->setNome($request->get('nome') ? $request->get('nome') : $name);
            $musicaAnexo->setMusica($musica);
            $musicaAnexo->setTipo($tipo);
            $musicaAnexo->setLinkExterno(false);
            $musicaAnexo->setLink($request->get('link') ? $request->get('link') : $name);
            $musicaAnexo->setUsuario($usuario);
            $musicaAnexo->setCadastro(new \DateTime('now'));
            $musicaAnexo->setAtivo(true);

            $app['db']->beginTransaction();
            $app['musica.anexos.repository']->save($musicaAnexo);
            $app['db']->commit();

            $mensagem = 'Adicionou o arquivo ' . $musicaAnexo->getNome();
            $app['log.controller']->criar($mensagem);
        }

        return $app->json(
            [
                'class' => 'success',
                'id' => $musicaAnexo->getId(),
                'message' => $mensagem
            ]
        );
    } catch(Exception $e) {
        return $app->json(
            [
                'class' => 'error',
                'message' => $e->getMessage()
            ]
        );
    }

})->bind('musica_anexos_upload');

$anexos->post('/musica/{musicaId}/anexos/save', function($musicaId, \Symfony\Component\HttpFoundation\Request $request) use ($app) {

    ini_set('display_errors', E_ALL);

    /**
     * @var \Api\Entities\Musica $musica
     */
    $musica = $app['musica.repository']->find($musicaId);
    $user = $app['session']->get('user');
    $usuario = $app['usuarios.repository']->find($user->getId());


    if (!$request->get('tipo')) {
        throw new Exception('Tipo não encontrado');
    }

    /**
     * @var \Api\Entities\Tipo $tipo
     */
    $tipo = $app['tipo.anexo.repository']->find($request->get('tipo'));

    $link = $request->get('link');

    if ($tipo->getNome() == 'Video') {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $request->get('link'), $matches);
        if (!empty($matches[0])) {
            $link = "https://www.youtube.com/embed/" . $matches[0];
        }
    }

    $musicaAnexo = new \Api\Entities\MusicaAnexos();
    $musicaAnexo->setNome($request->request->get('nome') ?: $musica->getNome());
    $musicaAnexo->setMusica($musica);
    $musicaAnexo->setTipo($tipo);
    $musicaAnexo->setLinkExterno(true);
    $musicaAnexo->setLink($link);
    $musicaAnexo->setUsuario($usuario);
    $musicaAnexo->setCadastro(new \DateTime('now'));
    $musicaAnexo->setAtivo(true);

    $app['db']->beginTransaction();
    $app['musica.anexos.repository']->save($musicaAnexo);
    $app['db']->commit();

    $mensagem = 'Adicionou o arquivo '.$musicaAnexo->getNome();

    return $app->json(
        [
            'class' => 'success',
            'message' => $mensagem
        ]
    );

})->bind('save_musica_anexos');

$anexos->post('/musica/{id}/anexos/comentar', function($id, \Symfony\Component\HttpFoundation\Request $request) use ($app) {

    try {

        if (!$request->get('id')) {
            throw new InvalidArgumentException('Deve ser inrmada a musica.');
        }
        if (empty($request->get('comentario'))) {
            throw new InvalidArgumentException('O texto não pode estar vazio.');
        }

        $musica = $app['musica.repository']->find($request->get('id'));

        $user = $app['session']->get('user');
        $usuario = $app['usuarios.repository']->find($user->getId());

        $comentario = new \Api\Entities\Comentarios();
        $comentario->setComentario($request->get('comentario'));
        $comentario->setMusica($musica);
        $comentario->setUsuario($usuario);
        $comentario->setCadastro(new \DateTime('now'));
        $comentario->setAtivo(true);

        $app['db']->beginTransaction();
        $app['comentario.repository']->save($comentario);
        $app['db']->commit();

        return $app->json(
            [
                'class' => 'success',
                'message' => 'Comentário enviado com sucesso.'
            ]
        );
    } catch (Exception $e) {
        return $app->json(
            [
                'class' => 'error',
                'message' => $e->getMessage()
            ]
        );
    }

})->bind('comentar_musica');

$anexos->post('/musica/anexos/comentario/{comentarioId}/remover', function ($comentarioId) use ($app) {

    /**
     * @var \Api\Entities\Comentarios $comentario
     */
    $comentario = $app['comentario.repository']->find($comentarioId);

    $app['db']->beginTransaction();
    $app['comentario.repository']->remove($comentario);
    $app['db']->commit();

    $mensagem = 'Comentário removido com sucesso.';

    return $app->json(
        [
            'class' => 'success',
            'message' => $mensagem
        ]
    );
});

return $anexos;