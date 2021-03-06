<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 09:20
 */

#################################################################################################
#################################################################################################
#  Controllers
#################################################################################################
#################################################################################################

use Api\Entities\Categoria;
use Api\Entities\Usuarios;
use Api\Services\Email;
use App\Entities\Config;
use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app['index.controller'] = function () use ($app) {
    return new \Api\Controllers\IndexController();
};
$app['post.controller'] = function () use ($app) {
    return new \Api\Controllers\PostController();
};
$app['tag.controller'] = function () use ($app) {
    return new \Api\Controllers\TagsController();
};
$app['menu.controller'] = function () use ($app) {
    return new \App\Controllers\MenuController();
};
$app['usuarios.controller'] = function () use ($app) {
    return new \Api\Controllers\UsuariosController();
};
$app['config.controller'] = function () use ($app) {
    return new \App\Controllers\ConfigController();
};
$app['categoria.controller'] = function () use ($app) {
    return new \Api\Controllers\CategoriaController();
};
$app['colecao.controller'] = function () use ($app) {
    return new \Api\Controllers\ColecaoController();
};
$app['musica.controller'] = function () use ($app) {
    return new \Api\Controllers\MusicaController($app);
};
$app['musica.anexos.controller'] = function () use ($app) {
    return new \Api\Controllers\MusicaAnexosController();
};
$app['tipo.anexo.controller'] = function () use ($app) {
    return new \Api\Controllers\MusicaAnexosController();
};
$app['pager.Controller'] = function () {
    return new \App\Controllers\PagerController();
};
$app['email.confirmacao.controller'] = function () {
    return new \Api\Controllers\EmailConfirmacaoController();
};
$app['search.controller'] = function () {
    return new \Api\Controllers\SearchController();
};
$app['log.controller'] = function () use ($app) {
    return new \Api\Controllers\LogController($app);
};
$app['comentario.controller'] = function () use ($app) {
    return new \Api\Controllers\ComentarioController();
};

#################################################################################################
#################################################################################################
# Repositories
#################################################################################################
#################################################################################################

$app['menu.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\App\Entities\Menu::class);
};
$app['config.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\App\Entities\Config::class);
};
$app['posts.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Posts::class);
};
$app['tags.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Tags::class);
};
$app['posts.links.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\LinksPosts::class);
};
$app['musica.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Musica::class);
};
$app['musica.anexos.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\MusicaAnexos::class);
};
$app['tipo.anexo.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Tipo::class);
};
$app['usuarios.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Usuarios::class);
};
$app['colecao.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Colecao::class);
};
$app['categoria.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Categoria::class);
};
$app['widgets.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\App\Entities\Widgets::class);
};
$app['log.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Log::class);
};
$app['comentario.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Comentarios::class);
};
$app['album.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Album::class);
};
$app['favoritos.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Favoritos::class);
};
$app['email.confirmacao.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\EmailConfirmacao::class);
};
$app['status.email.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\StatusEmail::class);
};
$app['sugestao.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Sugestao::class);
};
$app['sugestao.resposta.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\SugestaoResposta::class);
};
$app['login.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Login::class);
};
$app['email.enviado.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\EmailEnviado::class);
};
$app['cidades.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Cidades::class);
};
$app['grupo.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Grupo::class);
};
$app['grupo.musicas.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\GrupoMusicas::class);
};
$app['grupo.usuarios.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\GrupoUsuarios::class);
};
$app['playlist.musicas.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\PlaylistMusicas::class);
};
$app['playlist.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Playlist::class);
};
$app['anexo.download.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\AnexoDownload::class);
};
$app['grupo.musicas.situacao.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\GrupoMusicaSituacao::class);
};
$app['notificacao.repository'] = function () use ($app) {
    return $app['orm.em']->getRepository(\Api\Entities\Notificacao::class);
};

#################################################################################################
#################################################################################################
# Services
#################################################################################################
#################################################################################################

$app['upload.service'] = function () use ($app) {
    return new \App\Controllers\UploadImages();
};

$app['cidades'] = function () use ($app) {

    if (!empty($app['session']->get('cidades'))) {
        return $app['session']->get('cidades');
    }

    $cidades = $app['cidades.repository']->findAll();
    $app['session']->set('cidades', $cidades);

    return $cidades;
};

$app['colecoes'] = function () use ($app) {
    return $app['colecao.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);
};

$app['categorias'] = function () use ($app) {

    if (!empty($app['session']->get('categorias'))) {
        return $app['session']->get('categorias');
    }

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

    $categoriasArray = array_merge($array);

    $app['session']->set('categorias', $categoriasArray);
    return $app['session']->get('categorias');
};


$app['categorias_musicas'] = function () use ($app) {

    if (!empty($app['session']->get('categorias'))) {
        return $app['session']->get('categorias');
    }

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
                "nome" => $categoria->getNome(),
                "musicas" => $app['musica.repository']->findBy(['categoria' => $categoria])
            ];
        }
    }

    $categoriasArray = array_merge($array);

    $app['session']->set('categorias', $categoriasArray);
    return $app['session']->get('categorias');
};

$app['categories'] = function () use ($app) {
    return $app['tags.repository']->findAll();
};
$app['menus'] = function () use ($app) {
    return $app['menu.repository']->findBy(['ativo' => true]);
};

$app['config'] = function () use ($app) {
    return $app['config.repository']->find(1);
};

$app['config.blog'] = function () use ($app) {
    return $app['config.repository']->find(2);
};

$app['widgets'] = function () use ($app) {
    return $app['widgets.controller']->getAll($app);
};

$app['nome.blog'] = function () use ($app) {
    $default = $app['config.repository']->findAll();
    return $default[0]->getNome() ?: 'Coletânea ICM';
};

$app['blog'] = function () use ($app) {
    $default = $app['config.repository']->findAll();
    return $default[0] ?: [];
};

$app['blog2'] = function () use ($app) {
    $default = $app['config.repository']->findAll();
    return $default[1] ?: [];
};

$app['background'] = function () use ($app) {

    /**
     * @var Config $default
     */
    $default = $app['config.repository']->findOneBy([]);

    $img = $default->getBackground() ?: $app['background.default'];

    return $app['dir.img'] . $img;

};

$app['tonalidades'] = function () {
    return ['C', 'C#', 'Db', 'D', 'D#', 'Eb', 'E', 'F', 'F#', 'Gb', 'G', 'G#', 'Ab', 'A', 'A#', 'Bb', 'B',];
};
$app['adress'] = function () {
    return [
        '172.23.0.1',
        '127.0.0.1',
        '::1'
    ];
};
$app['dir.base'] = function () use ($app) {

    if (in_array($_SERVER['REMOTE_ADDR'], $app['adress'])) {
        return '';
    }

    return '/';
};
$app['dir.base2'] = function () use ($app) {

    if (in_array($_SERVER['REMOTE_ADDR'], $app['adress'])) {
        return '';
    }

    return '/web';
};

$app['dir.base3'] = function () use ($app) {
    return 'https://coletaneaicm.com/web/';
};

$app['database'] = function () use ($app) {
    return [
        'dbname' => 'blogcezzaar',
        'user' => 'cezzaar94',
        'password' => 'elpro1973',
        'host' => 'mysql857.umbler.com:41890',
        'driver' => 'pdo_mysql',
    ];
};

$app['dir.img'] = function () use ($app) {
    return $app['dir.base3'] . 'assets/blog/img/config/';
};
$app['dir.post'] = function () use ($app) {
    return $app['dir.base'] . 'assets/blog/img/posts/';
};
$app['dir.avatar'] = function () use ($app) {
    return $app['dir.base3'] . 'assets/blog/img/avatar/';
};
$app['dir.widgets'] = function () use ($app) {
    return $app['dir.base'] . 'assets/blog/img/widgets/';
};
$app['dir.menu'] = function () use ($app) {
    return $app['dir.base3'] . 'assets/blog/img/menu/';
};
$app['dir.colecao'] = function () use ($app) {
    return $app['dir.base3'] . 'assets/blog/img/colecoes/';
};
$app['dir.anexo'] = function () use ($app) {
    return $app['dir.base3'] . 'assets/blog/musicas/';
};
$app['dir.album'] = function () use ($app) {
    return $app['dir.base'] . 'assets/blog/img/albuns/';
};

$app['background.default'] = $app['dir.base3'] . 'assets/blog/img/wallpaper.jpg';
$app['background.post.default'] = $app['dir.base3'] . 'assets/blog/img/wallpaper.jpg';
$app['avatar.default'] = function () use ($app) {
    return $app['dir.base3'] . 'assets/blog/img/defaults/avatar.png';
};


$app['about'] = function () use ($app){
    return $app['blog']->getAbout();
};

$app['default.card'] = function () use ($app) {
    $default = $app['config.repository']->findAll();
    if (!empty($default[0]->getBackground())) {
        return $app['dir.base'] . 'assets/blog/img/config/' . $default[0]->getBackground();
    }
    return $app['dir.base'] . 'assets/blog/img/wallpaper.jpg';
};

$app['uuid.service'] = function () {
    return Ramsey\Uuid\Uuid::uuid4();
};

$app['usuario.sessao'] = function () use ($app) {

    /**
     * @var Usuarios $user
     */
    $user = $app['session']->get('user');

    if (empty($user)) {
        return[];
    }

    return [
        'id' => $user->getId(),
        'nome' => $user->getNome(),
        'email' => $user->getUsername()
    ];
};

$app['usuario'] = function () use ($app) {

    if (!isset($app['usuario.sessao']['id'])) {
        return $app->redirect('login');
    }

    return $app['usuarios.repository']->find($app['usuario.sessao']['id']);
};

$app['email.padrao'] = function () {
    return 'contato.coletaneaicm@gmail.com';
};
