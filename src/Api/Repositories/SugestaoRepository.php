<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 11/04/17
 * Time: 09:35
 */

namespace Api\Repositories;

use Api\Entities\Sugestao;
use Doctrine\ORM\EntityRepository;

/**
 * Class SugestaoRepository
 * @package Api\Repositories
 */
class SugestaoRepository extends EntityRepository
{
    /**
     * @param Sugestao $sugestao
     */
    public function save(Sugestao $sugestao)
    {
        $this->_em->persist($sugestao);
        $this->_em->flush($sugestao);
    }
}