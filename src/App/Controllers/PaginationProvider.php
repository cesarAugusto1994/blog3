<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 09/09/16
 * Time: 16:57
 */

namespace App\Controllers;


use Doctrine\ORM\EntityRepository;
use Silex\Application;

class PaginationProvider
{
    private $page = 1;
    private $source;
    private $entity;
    private $entityRepository;
    private $offset = 0;
    private $limit = 5;
    
    /**
     * PaginationProvider constructor.
     * @param Application $entityRepository
     * @param string $entity
     * @param PaginationInterface $paginationInterface
     */
    public function __construct(PaginationInterface $paginationInterface)
    {
        $this->entityRepository = $paginationInterface;
    }
    
    /**
     * @param int $page
     */
    public function generate($page)
    {
        $this->page = (int)$page;
        
        return $this->entityRepository->find(1);
    }
}