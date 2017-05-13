<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 11/04/17
 * Time: 09:35
 */

namespace Api\Repositories;

use Api\Entities\AnexoDownload;
use Doctrine\ORM\EntityRepository;

/**
 * Class AnexoDownloadRepository
 * @package Api\Repositories
 */
class AnexoDownloadRepository extends EntityRepository
{
    /**
     * @param AnexoDownload $anexoDownload
     */
    public function save(AnexoDownload $anexoDownload)
    {
        $this->_em->persist($anexoDownload);
        $this->_em->flush($anexoDownload);
    }

    /**
     * @param AnexoDownload $anexoDownload
     */
    public function remove(AnexoDownload $anexoDownload)
    {
        $this->_em->remove($anexoDownload);
        $this->_em->flush($anexoDownload);
    }
}