<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 19/09/16
 * Time: 10:33
 */

namespace App\Model\Fixtures;

use Api\Entities\Tipo;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Tipos implements FixtureInterface
{
    private $data = [
        [
            'nome' => 'Documento',
            'ativo' => 1,
        ],
        [
            'nome' => 'Audio',
            'ativo' => 1,
        ],
        [
            'nome' => 'Doc',
            'ativo' => 1,
        ],
        [
            'nome' => 'Video',
            'ativo' => 1,
        ]
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $data) {
            $tipo = new Tipo();
            $tipo->setNome($data['nome']);
            $tipo->setAtivo(true);
            $manager->persist($tipo);
        }
        $manager->flush();
    }
}