<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/11/16
 * Time: 09:46
 */

$album = $app['controllers_factory'];

$album->get('albuns', function () use ($app) {
    $albuns = $app['album.repository']->findAll();
    return new \Symfony\Component\HttpFoundation\JsonResponse($albuns);
})->bind('api_albuns');

$album->get('albuns/view', function () use ($app) {
    return $app['twig']->render('user/albuns.html.twig');
})->bind('albuns_view');

$album->post('albuns/adicionar', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    try {

        if ($request->request->get('nome')) {
            //
        }

        $album = new \Api\Entities\Album();
        $album->setLabel($request->request->get('nome'));

        if (!empty($_FILES['img']['size'])) {
            $album->setImagem($app['upload.service']->upload($_FILES['img'],
                \App\Controllers\UploadImages::ORIGIN_ALBUM, $album->getImagem()));
        }

        $app['db']->beginTransaction();
        $app['album.repository']->save($album);
        $app['db']->commit();

        if ($_FILES['files']) {

            foreach ($_FILES['files']['name'] as $key => $name) {

                if (empty($name)) {
                    continue;
                }

                $name = substr($name, 0, -4);

                $musica = new \Api\Entities\Musica();

                $musica->setNome(strtoupper($name));
                $musica->setNumero(null);
                $musica->setTom('C');

                if ($request->request->get('categoria')) {
                    $categoria = $app['categoria.repository']->find($request->request->get('categoria'));
                    $musica->setCategoria($categoria);
                }
                
                $musica->setAlbum($album);
                $musica->setUsuario($app['usuario']);
                $musica->setCadastro(new \DateTime('now'));
                $musica->setNovo(false);
                $musica->setAtivo(true);

                $app['db']->beginTransaction();
                $app['musica.repository']->save($musica);
                $app['db']->commit();

                $tipo = $app['tipo.anexo.repository']->find(
                    \App\Controllers\MediaFormat::getFormatTipo($_FILES['files']['type'][$key])
                );

                $musicaAnexo = new \Api\Entities\MusicaAnexos();
                $musicaAnexo->setNome($name);
                $musicaAnexo->setMusica($musica);
                $musicaAnexo->setTipo($tipo);
                $musicaAnexo->setLinkExterno(false);
                $musicaAnexo->setUsuario($app['usuario']);
                $musicaAnexo->setCadastro(new \DateTime('now'));
                $musicaAnexo->setAtivo(true);

                $app['db']->beginTransaction();
                $app['musica.anexos.repository']->save($musicaAnexo);
                $app['db']->commit();
            }

            $uploader = new \App\Controllers\Uploader();
            $data = $uploader->upload(
                $_FILES['files'],
                array(
                    'limit' => 100,
                    'maxSize' => 120,
                    'extensions' => null,
                    'required' => false,
                    'title' => array('name'),
                    'removeFiles' => true,
                    'replace' => true,
                    'perms' => null,
                    'onCheck' => null,
                    'onError' => null,
                    'onSuccess' => null,
                    'onUpload' => null,
                    'onComplete' => true,
                    'onRemove' => null
                )
            );
        }

        return $app->json([
            'classe' => 'sucesso',
            'message' => 'Album Adicionado.'
        ]);

    }catch (Exception $e) {
        return $app->json([
            $e->getMessage()
        ]);
    }
});

return $album;