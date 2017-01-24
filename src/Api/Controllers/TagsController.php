<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 08/09/16
 * Time: 09:28
 */

namespace Api\Controllers;


use Api\Entities\Posts;
use Silex\Application;

class TagsController
{
    public function postsRelacionados(Posts $post, Application $app)
    {
        $postsRelacionados = $tagsRelacionadas = [];
        
        foreach ($post->getTags() as $tag) {
        
            if (!empty($tag)) {
            
                $tagsRelacionadas = $app['tags.repository']->findByName($tag->getNome());
            
                foreach ($tagsRelacionadas as $tags) {
                
                    if(in_array($tags->getPost(), $postsRelacionados)) {
                        continue;
                    }
                    $postsRelacionados = [$tags->getPost()];
                }
            }
        }

        return $postsRelacionados;
    }
}