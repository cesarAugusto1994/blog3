<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 06/09/16
 * Time: 14:48
 */

namespace App\Controllers;


use Silex\Application;

class PagerController
{
    private $data;
    private $countData;
    private $offset = 0;
    private $limit = 5;
    private $firstPage = 1;
    private $nextPage;
    
    /**
     * @return int
     */
    public function getCountData()
    {
        return $this->countData;
    }
    
    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }
    
    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }
    
    /**
     * @return mixed
     */
    public function getFirstPage()
    {
        return $this->firstPage;
    }
    
    /**
     * @return mixed
     */
    public function getNextPage()
    {
        return $this->nextPage;
    }
    
    /**
     * @param array $data
     * @param int $page
     * @return $this
     */
    public function pager(array $data, $page = 1)
    {
        $this->countData = count($this->data = $data);
        
        $countPages = ceil(($this->countData ? $this->countData : 1) / $this->limit);

        if ($page > 1 && $page <= $countPages) {
            for ($i = 0; $i < $page; $i++) {
                $this->offset = $page * 2 - 1;
            }
        } elseif ($page >= $countPages) {
            $page = $countPages;
        }

        if ($page < $countPages) {
            $this->firstPage = $page - 1;
            $this->nextPage = $page + 1;
        } elseif ($page == $countPages) {
            $this->firstPage = $page - 1;
        } elseif ($page >= 1) {
            $this->firstPage = $page - 1;
        }

        return $this;
    }

}