<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 21/10/16
 * Time: 08:46
 */

namespace Api\Services;

use Silex\Application;

class ImageService
{
    const COLECOES = '';
    
    private $app;
    
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}