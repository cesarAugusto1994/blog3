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

/**
 * Class PostController
 * @package Api\Controllers
 */
class PostController
{
    use WorkWithStrings;
    use UploadImages;

    /**
     * @param int $id
     * @param Application $app
     * @return mixed
     */
    public function post($id, Application $app)
    {
        $post = $app['posts.repository']->findBy(['id' => $id, 'ativo' => true]);

        $postsRelacionados = [];
        $tagsRelacionadas = [];

        foreach ($post as $singlePost) {

            foreach ($singlePost->getTags() as $tag) {

                if (!empty($tag)) {

                    $tagsRelacionadas = $app['tags.repository']->findByName($tag->getNome());

                    foreach ($tagsRelacionadas as $tags) {

                        if(in_array($tags->getPost(), $postsRelacionados)) {
                            continue;
                        }
                        $postsRelacionados[] = $tags->getPost();
                    }
                }
            }
        }

        $links = $app['posts.links.repository']->findBy(['post' => $id]);

        if (empty(current($post))) {
            return $app->redirect('/');
        }

        return $app['twig']->render('post.html.twig', [
            'post' => current($post),
            'links' => $links,
            'posts_relacionados' => $postsRelacionados
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

        return $app['twig']->render('index.html.twig', [
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

        return $app['twig']->render('index.html.twig', [
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

        $app['posts.repository']->save($post);

        return $app->redirect('post/'.$post->getId().'/'.$this->replaceSpecialStringsFromUrl($post->getTitulo()));
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function criar(Request $request, Application $app)
    {
        $post = new Posts();
        $usuario = $app['usuarios.repository']->find(1);
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

        $app['posts.repository']->save($post);

        $arrTags = explode(',', $request->get('tags'));

        foreach ($arrTags as $tag) {
            if (!empty($tag)) {
                $tags = new Tags();
                $tags->setPost($post);
                $tags->setNome($this->replaceSpecialStrings($tag));
                $app['tags.repository']->save($tags);
            }
        }

        return $app->redirect('post/'.$post->getId().'/'.$this->replaceSpecialStringsFromUrl($post->getTitulo()));
    }
    
    /**
     * @param int $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
        public function alterarStatus($id, Application $app)
    {
        /**
         * Posts $post
         */
        $post = $app['posts.repository']->find($id);
        $post->setAtualizado(new \DateTime('now'));

        if ($post->isAtivo() == true) {
            $post->setAtivo(false);
        } else {
            $post->setAtivo(true);
        }
    
        $app['posts.repository']->save($post);
    
        return $app->redirect('/grid_posts');
    }
}