<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 01/08/16
 * Time: 15:58
 */

namespace Api\Controllers;

use Api\Entities\Posts;
use Api\Entities\Tags;
use App\Controllers\UploadImages;
use App\Controllers\WorkWithStrings;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Controllers\PagerController;

/**
 * Class PostController
 * @package Api\Controllers
 */
class PostController
{
    use WorkWithStrings;
    use UploadImages;
    
    /**
     * @param int $page
     * @param Application $app
     * @return mixed
     */
    public function posts($page = 1, Application $app)
    {
        $pager = $app['pager.Controller'];
        $pager->pager($app['posts.repository']->findBy(['ativo' => true], ['cadastro' => 'DESC']), $page);
    
        return $app['twig']->render('/user/posts.html.twig', [
            'posts' => $app['posts.repository']->getAll($pager->getOffset(), $pager->getLimit()),
            'firstPage' => $pager->getFirstPage(),
            'nextPage' => $pager->getNextPage(),
            'limitPerPage' => $pager->getLimit(),
            'records' => $pager->getCountData()
        ]);
    }
    
    /**
     * @param int $id
     * @param Application $app
     * @return mixed
     */
    public function post($id, Application $app)
    {
        $post = $app['posts.repository']->find($id);
        $links = $app['posts.links.repository']->findBy(['post' => $id]);

        return $app['twig']->render('/user/post.html.twig', [
            'post' => $post,
            'links' => $links,
            'posts_relacionados' => []
        ]);
    }

    /**
     * @param $year
     * @param Application $app
     * @return mixed
     */
    public function postsByYear($year, Application $app)
    {
        return $app['twig']->render('posts.html.twig', [
            'posts' => $app['posts.repository']->findBy(['year' => $year, 'ativo' => true], ['cadastro' => 'DESC']),
        ]);
    }

    /**
     * @param $year
     * @param $month
     * @param Application $app
     * @return mixed
     */
    public function postsByYearAndMonth($year, $month, Application $app)
    {
        return $app['twig']->render('posts.html.twig', [
            'posts' => $app['posts.repository']->findBy(['year' => $year, 'month' => $month, 'ativo' => true], ['cadastro' => 'DESC']),
        ]);
    }

    /**
     * @param $author
     * @param Application $app
     * @return mixed
     */
    public function postsByAuthor($author, Application $app)
    {
        $author = $app['usuarios.repository']->find($author);

        return $app['twig']->render('/user/index.html.twig', [
            'posts' => $app['posts.repository']->findBy(['usuario' => $author->getId(), 'ativo' => true], ['cadastro' => 'DESC']),
            'author_message' => 'Posts criados por: '.$author->getNome()
        ]);
    }

    /**
     * @param int $tag
     * @param Application $app
     * @return mixed
     */
    public function postsByTags($tag, Application $app)
    {
        $posts = array_map(function ($tag) use($app) {
            return $tag->getPost();
        }, $app['tags.repository']->findByName($tag));

        return $app['twig']->render('/user/index.html.twig', [
            'posts' => $posts,
            'tag_message' => 'Posts relacionados com: '. $tag
        ]);
    }

    /**
     * @param string $search
     * @param Application $app
     * @return mixed
     */
    public function search($search, Application $app)
    {
        $posts = $app['posts.repository']->search($search);

        return $app['twig']->render('index.html.twig', [
            'posts' => $posts,
            'message' => ' Parâmetro de pesquisa: '.$search
        ]);
    }
    
    /**
     * @param int $id
     * @param Application $app
     * @return mixed
     */
    public function editarPost($id, Application $app)
    {
        return $app['twig']->render('admin/edit_post.html.twig', [
            'post' => $app['posts.repository']->find($id),
        ]);
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editar(Request $request, Application $app)
    {
        /**
         * Posts $post
         */
        $post = $app['posts.repository']->find($request->get('id'));

        $post->setTitulo($this->replaceSpecialStrings($request->get('titulo')));
        $post->setDescricao($request->get('descricao'));
        $post->setConteudo(strip_tags($request->get('descricao')));
        $post->setAtualizado(new \DateTime('now'));

        if (!empty($_FILES['background']['size'])) {
            $post->setBackground($this->upload($_FILES['background'], 'post', $post->getBackground()));
        }
    
        $app['db']->beginTransaction();
        $app['posts.repository']->save($post);
        $app['db']->commit();
    
        $arrTags = explode(',', $request->get('tags'));

        if (!empty($arrTags)) {

            $tagsPost = $app['tags.repository']->findBy(['post' => $post]);

            if ($tagsPost) {
                foreach ($tagsPost as $tag) {
                    $app['tags.repository']->remove($tag);
                }
            }

            foreach ($arrTags as $tag) {
                if (!empty($tag)) {
                    $tags = new Tags();
                    $tags->setPost($post);
                    $tags->setNome($this->replaceSpecialStrings($tag));
                    $app['tags.repository']->save($tags);
                }
            }
        }

        return $app->redirect('/user/post/'.$post->getId().'/'.$this->replaceSpecialStringsFromUrl($post->getTitulo()));
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function criar(Request $request, Application $app)
    {
        $post = new Posts();
        $user = $app['session']->get('user');
        $usuario = $app['usuarios.repository']->find($user->getId());
        $dataCadastro = new \DateTime();
        
        $post->setTitulo($this->replaceSpecialStrings($request->get('titulo')));
        $post->setDescricao($request->get('descricao'));
        $post->setConteudo(strip_tags($request->get('descricao')));
        $post->setCadastro($dataCadastro);
        $post->setYear($dataCadastro->format('Y'));
        $post->setMonth($dataCadastro->format('m'));
        $post->setUsuario($usuario);
        $post->setAtivo(true);

        if (!empty($_FILES['background']['size'])) {
            $post->setBackground($this->upload($_FILES['background'], 'post', $post->getBackground()));
        }
    
        $app['db']->beginTransaction();
        $app['posts.repository']->save($post);
        $app['db']->commit();
    
        $arrTags = explode(',', $request->get('tags'));

        foreach ($arrTags as $tag) {
            if (!empty($tag)) {
                $tags = new Tags();
                $tags->setPost($post);
                $tags->setNome($this->replaceSpecialStrings($tag));
                $app['tags.repository']->save($tags);
            }
        }

        return $app->redirect('/user/post/'.$post->getId().'/'.$this->replaceSpecialStringsFromUrl($post->getTitulo()));
    }
    
    /**
     * @param int $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function alterarStatus($id, Application $app)
    {
        /**
         * @var Posts $post
         */
        $post = $app['posts.repository']->find($id);
        $post->setAtualizado(new \DateTime('now'));

        if ($post->isAtivo() == true) {
            $post->setAtivo(false);
        } else {
            $post->setAtivo(true);
        }
    
        $app['db']->beginTransaction();
        $app['posts.repository']->save($post);
        $app['db']->commit();
    
        $mensagem = 'Situação do Post  ' . $post->getTitulo() . ' alterado para ' .($post->isAtivo() ? 'ativo' : 'inativo'). ' com sucesso.';

        $app['log.controller']->criar($mensagem);
        $app['session']->getFlashBag()->add('mensagem', $mensagem);
    
        return $app->redirect('/admin/posts/grid');
    }
}