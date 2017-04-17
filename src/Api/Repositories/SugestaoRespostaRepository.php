<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 11/04/17
 * Time: 09:35
 */

namespace Api\Repositories;

use Api\Entities\Sugestao;
use Api\Entities\SugestaoResposta;
use Doctrine\ORM\EntityRepository;

/**
 * Class SugestaoRespostaRepository
 * @package Api\Repositories
 */
class SugestaoRespostaRepository extends EntityRepository
{
    /**
     * @param SugestaoResposta $sugestaoResposta
     */
    public function save(SugestaoResposta $sugestaoResposta)
    {
        $this->_em->persist($sugestaoResposta);
        $this->_em->flush($sugestaoResposta);
    }
}