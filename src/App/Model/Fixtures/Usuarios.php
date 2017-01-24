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

class Usuarios implements FixtureInterface
{
    private $data = [
        [
            'nome' => 'Cesar Augusto',
            'email' => 'cezzaar@gmail.com',
            'password' => '123456789',
        ],
        [
            'nome' => 'Fabiana Silva',
            'email' => 'cezzaar@gmail.com',
            'password' => '123456789',
        ],
        [
            'nome' => 'Julio César',
            'email' => 'cezzaar@gmail.com',
            'password' => '123456789',
        ]
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $data) {
            $usuario = new \Api\Entities\Usuarios();
            $usuario->setNome($data['nome']);
            $usuario->setEmail($data['email']);
            $usuario->setPassword($data['password']);
            $usuario->setCadastro(new \DateTime());
            $usuario->setAtivo(true);
            $manager->persist($usuario);
        }
        $manager->flush();
    }
}