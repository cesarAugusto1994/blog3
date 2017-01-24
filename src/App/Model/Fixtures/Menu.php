<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 19/09/16
 * Time: 10:33
 */

namespace App\Model\Fixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Menu implements FixtureInterface
{
    private $data = [
        [
            'nome' => 'Configurações',
            'descricao' => 'Informações do Blog',
            'url' => 'blog',
            'icon' => 'cogs',
        ],
        [
            'nome' => 'Contato',
            'descricao' => 'Contato',
            'url' => 'contact',
            'icon' => 'message-o',
        ],
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $data) {
            $usuario = new \App\Entities\Menu();
            $usuario->setNome($data['nome']);
            $usuario->setDescricao($data['descricao']);
            $usuario->setUrl($data['url']);
            $usuario->setIcon($data['icon']);
            $usuario->setCadastro(new \DateTime());
            $usuario->setAtivo(true);
            $manager->persist($usuario);
        }
        $manager->flush();
    }
}