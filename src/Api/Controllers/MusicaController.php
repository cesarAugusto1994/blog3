<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 10:41
 */

namespace Api\Controllers;

use Api\Entities\Categoria;
use Api\Entities\Musica;
use Api\Entities\Usuarios;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MusicaController
 * @package Api\Controllers
 */
class MusicaController
{
    private $app;

    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function index($categoriaId, Application $app)
    {

    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function newAction(Request $request)
    {
        if (0 == $request->request->count()) {
            throw new \InvalidArgumentException("Nao foi possivel adicionar esta m&uacute;sica: Nenhum dado foi informado.");
        }

        if ($this->app['musica.repository']->findBy(['nome' => $request->get('nome')])) {
            throw new \Exception("Não foi poss&iacute;vel adicionar m&uacute;sica: M&uacute;sica já adiconada.");
        }

        if (empty($request->get('nome'))) {
            throw new \Exception("Não foi possivel Adicionar musica: O nome nao foi informado.");
        }

        if (empty($request->get('categoria'))) {
            throw new \Exception("Não foi possivel Adicionar musica: A Categoria nao foi informada.");
        }

        /**
         * @var \Api\Entities\Categoria $categoria
         */
        $categoria = $this->app['categoria.repository']->find($request->get('categoria'));
        $user = $this->app['session']->get('user');
        /**
         * @var \Api\Entities\Usuarios $usuario
         */
        $usuario = $this->app['usuarios.repository']->find($user->getId());

        $musica = new Musica();

        $musica->setNome(strtoupper($request->get('nome')));
        $musica->setNumero($request->get('numero') ?: null);
        $musica->setTom($request->get('tonalidade'));

        if ($request->get('album')) {
            $album = $this->app['album.repository']->find($request->get('album'));
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

        $this->app['db']->beginTransaction();
        $this->app['musica.repository']->save($musica);
        $this->app['db']->commit();

        if (Usuarios::ROLE_ADMIN != $usuario->getRoles()) {
            return $this->app->json([
                "classe" => "success",
                "redirect" => true,
                "message" => "Sua Sugestão Foi enviada, embre ele será publicada.",
            ], 201);
        }

        return $this->app->json([
            "classe" => "sucess",
            "redirect" => false,
            "message" => "Musica adicionanda com sucesso.",
        ], 201);
    }

    /**
     * @param array $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function newFromArrayAction(array $request)
    {
        if (empty($request)) {
            throw new \InvalidArgumentException("Nao foi possivel Adicionar musica: Nenhum dado foi informado.");
        }

        if ($this->app['musica.repository']->findBy(['nome' => $request['nome']])) {
            throw new \Exception("Não foi possivel Adicionar musica: Música já adiconada.");
        }

        if (empty($request['nome'])) {
            throw new \Exception("Não foi possivel Adicionar musica: O nome nao foi informado.");
        }

        if (empty($request['categoria'])) {
            throw new \Exception("Não foi possivel Adicionar musica: A Categoria nao foi informada.");
        }

        /**
         * @var \Api\Entities\Categoria $categoria
         */
        $categoria = $this->app['categoria.repository']->find($request['categoria']);
        $user = $this->app['session']->get('user');
        /**
         * @var \Api\Entities\Usuarios $usuario
         */
        $usuario = $this->app['usuarios.repository']->find($user->getId());

        $musica = new Musica();

        $musica->setNome(strtoupper($request['nome']));
        $musica->setNumero($request['numero'] ?: null);
        $musica->setTom($request['tonalidade']);

        if ($request['album']) {
            $album = $this->app['album.repository']->find($request['album']);
            $musica->setAlbum($album);
        }

        if ($request['letra']) {

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

            $letra = str_replace($search, $replace, $request['letra']);
            $musica->setLetra(strip_tags(htmlspecialchars_decode($letra)));
            $musica->setLetraOriginal($letra);
        }

        $musica->setCategoria($categoria);
        $musica->setUsuario($usuario);
        $musica->setCadastro(new \DateTime('now'));
        $musica->setNovo(false);

        if ($request['novo']) {
            $musica->setNovo($request['novo']);
        }

        $ativo = false;

        if (Usuarios::ROLE_ADMIN == $usuario->getRoles()) {
            $ativo = true;
        }

        $musica->setAtivo($ativo);

        $this->app['db']->beginTransaction();
        $this->app['musica.repository']->save($musica);
        $this->app['db']->commit();

        return $this->app->json([
            "classe" => "sucess",
            "message" => "Musica adicionanda com sucesso.",
        ], 201);
    }
    
    /**
     * @param $id
     * @param Application $app
     * @return mixed
     */
    public function editarMusica($id, Application $app, $edicaoUsuario = false, $editarLetra = false)
    {

    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function musicasGrid(Application $app)
    {
        
    }
    
    /**
     * @param $categoriaId
     * @param Application $app
     * @return mixed
     */
    public function categoriaMusicasGrid($categoriaId, Application $app)
    {
        
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function novo(Request $request, Application $app)
    {
        
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editar(Request $request, Application $app)
    {
        
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editarLetra(Request $request, Application $app)
    {

    }

    /**
     * @param int $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function alteraStatus($id, Application $app)
    {
        
    }
    
    
}