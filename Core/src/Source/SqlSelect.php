<?php
/**
 * Core ( Module for Zend Framework 2)
 *
 * @copyright Copyright (c) 2013 Piotr Duda dudapiotrek@gmail.com
 * @license   MIT License
 */

namespace Core\Source;

use Core\Source\AbstractSource;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

class SqlSelect extends AbstractSource
{

    /**
     *
     * @var Select
     */
    protected $quickSearchQuery;

    /**
     *
     * @var Select
     */
    protected $select;

    /**
     *
     * @var  \Zend\Paginator\Paginator
     */
    protected $paginator;

    /**
     *
     * @param Select $select
     */
    public function __construct(Select $select)
    {
        $this->select = $select;
    }

    /**
     *
     * @return Select
     */
    public function getSelect()
    {
        return $this->select;
    }

    /**
     *
     * @return Select
     */
    public function getSource()
    {
        return $this->select;
    }

    /**
     * Return data as PDO statement
     *
     * not-used
     * @return type
     */
    protected function getDataAsPdoStatement()
    {
        $statement = $this->getSql()->prepareStatementForSqlObject($this->select);
        return $statement->execute();
    }

    /**
     *
     * @return \Zend\Paginator\Paginator
     */
    public function getPaginator()
    {
        if (!$this->paginator) {
            $adapter = new DbSelect($this->getSelect(), $this->getTable()->getAdapter());
            $this->paginator = new Paginator($adapter);

            $this->order();

            $this->initPaginator();
        }
        return $this->paginator;
    }

    /**
     * Setting ordering
     */
    protected function order()
    {
        $column = $this->getParamAdapter()->getColumn();
        $order = $this->getParamAdapter()->getOrder();
        if ($column) {
            $this->select->reset('order');
            $this->select->order($column . ' ' . $order);
        }
    }

    /*
     * Init quick search
     */
    protected function quickSearch()
    {
        if ($this->getQuickSearchQuery()) {
            $where = $this->getQuickSearchQuery()->getRawState('where');
            $this->select->where($where);
        }
    }
}
