<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/10/16
 * Time: 16:22
 */

namespace Api\Controllers;

use Api\Entities\Log;
use Silex\Application;

/**
 * Class LogController
 * @package Api\Controllers
 */
class LogController
{
    /**
     * @var Application
     */
    private $app;

    /**
     * LogController constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param $mensagem
     */
    public function criar($mensagem)
    {
        $user = $this->app['session']->get('user');
        
        $usuario = $this->app['usuarios.repository']->find($user->getId());
        
        $log = new Log();
        $log->setMensagem($mensagem);
        $log->setUsuario($usuario);
        $log->setCadastro(new \DateTime('now'));
        
        $this->app['log.repository']->save($log);
    }
}