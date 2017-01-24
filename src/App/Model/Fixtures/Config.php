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

class Config implements FixtureInterface
{
    private $data = [
        [
            'nome' => 'Blog Teste',
            'subtitulo' => 'cezzaar@gmail.com',
            'background' => ''
        ]
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $data) {
            $usuario = new \App\Entities\Config();
            $usuario->setNome($data['nome']);
            $usuario->setSubtitulo($data['subtitulo']);
            $usuario->setBackground($data['background']);
            $manager->persist($usuario);
        }
        $manager->flush();
    }
}