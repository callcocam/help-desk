<?php
/**
 * Created by PhpStorm.
 * User: caltj
 * Date: 12/04/2018
 * Time: 23:36
 */

namespace Core\Repository;


use Doctrine\ORM\EntityRepository;

use Doctrine\ORM\QueryBuilder;
use Zend\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;

class AbstractRepository extends EntityRepository
{
    /**
     * @var Paginator
     */
    protected $paginator;
    /**
     * @var QueryBuilder
     */
    protected $Select;
    protected $endDate;
    protected $startDate;
    protected $tableAlias = 'p';

    protected $order = [
        'key' => 'id',
        'value' => 'DESC'
    ];
    protected $page = '1';
    protected $itemCountPerPage = 10;

    /**
     * @param string $alias
     * @param null $indexBy
     * @return AbstractRepository
     */
    public function QueryBuilder( $alias, $indexBy = null )
    {
        $this->setTableAlias($alias);
        $this->Select = parent::createQueryBuilder($alias, $indexBy);
        return $this;

    }

    /*
     * ***************************************
     * **********  PROTECTED METHODS  **********
     * ***************************************
     */
    public function getPaginator( $type = 'array' )
    {

        if (!$this->paginator) {
            $this->quickSearch();
            $this->quickOrder();
            $adapter = new DoctrineAdapter(new ORMPaginator($this->Select));
            $this->paginator = new Paginator($adapter);
            $this->initPaginator();
        }
        $res = array();
        $render = $this->extracted($this->paginator);
        $res['sEcho'] = $render;
        $res['iTotalDisplayRecords'] = $this->paginator->getTotalItemCount();
        $res['aaData'] = $render;
        $res['draw'] = $render;
        $res['data'] = $render;
        return $res;

    }

    /**
     * Init paginator
     */
    protected function initPaginator()
    {
        $this->paginator->setItemCountPerPage($this->getItemCountPerPage());
        $this->paginator->setCurrentPageNumber($this->getPage());
    }

    /**
     * @param mixed $endDate
     * @return AbstractRepository
     */
    public function setEndDate( $endDate )
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @param mixed $startDate
     * @return AbstractRepository
     */
    public function setStartDate( $startDate )
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return array
     */
    public function getOrder( $key )
    {
        return $this->order[$key];
    }

    /**
     * @param array $order
     * @return AbstractRepository
     */
    public function setOrder( array $order ): AbstractRepository
    {
        $this->order = $order;
        return $this;
    }

    /**
     *
     */
    protected function quickOrder()
    {
        $this->Select->orderBy($this->getTableAlias() . '.' . $this->getOrder('key'), $this->getOrder('value'));
    }

    /*
         * Init quick search
         */
    protected function quickSearch()
    {


    }

    protected function extracted( $data )
    {
        $entity = [];
        foreach ($data as $key => $value) {
            $entity[] = $value->toArray();
        }
        return $entity;
    }

    protected function getPage()
    {
        return $this->page;

    }

    /**
     * @return mixed
     */
    protected function getItemCountPerPage()
    {
        return $this->itemCountPerPage;
    }

    /**
     * @param string $tableAlias
     * @return AbstractRepository
     */
    public function setTableAlias( string $tableAlias ): AbstractRepository
    {
        $this->tableAlias = $tableAlias;
        return $this;
    }

    /**
     * @return string
     */
    public function getTableAlias(): string
    {
        return $this->tableAlias;
    }

}