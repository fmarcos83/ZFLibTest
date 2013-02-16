<?php

use ZendApp\Test\PHPUnit\TestCase as ZendAppTestCase;
use ZendApp\Data\DataGateway\DbDataGateway as DbDataGateway;

class DbDataGatewayTest extends ZendAppTestCase
{
    protected $dbtable = null;
    protected $rowset = null;

    public function setUp()
    {
        $this->dbtable = $this->getCleanMock('Zend_Db_Table');
        $this->dbrowset = $this->getCleanMock('Zend_Db_Table_Rowset');
    }

    public function testWhenInsertingDataOnZendDbTableIsExpectedData()
    {
        $data = array('name'=>'Francisco','id'=>1);
        $tg = new DbDataGateway;
        $tg->setTableGateWay($this->dbtable);
        $this->dbtable->expects($this->once())
            ->method('insert')->with($data);
        $tg->insert($data);
    }

    public function testWhenUpdatingDataOnZendDbTableIsExpectedData()
    {
        $data = array('name'=>'Francisco', 'id'=>1);
        $where = array('id=?'=>1);
        $expectedWhereClause = array('id=?'=>1);
        $tg = new DbDataGateway;
        $tg->setTableGateWay($this->dbtable);
        $this->dbtable->expects($this->once())
            ->method('update')->with($data, $expectedWhereClause);
        $tg->update($data, $where);
    }

    public function testWhenDeleteExpectedDataInZendDbTable()
    {
        $where = array('name=?'=>'Francisco');
        $expectedWhereClause = array('name=?'=>'Francisco');
        $tg = new DbDataGateway;
        $tg->setTableGateWay($this->dbtable);
        $this->dbtable->expects($this->once())
            ->method('delete')->with($expectedWhereClause);
        $tg->delete($where);
    }

    public function testWhenFindExpectedParamsInZendDbTableFetchAll()
    {
        $where = array('name=?'=>'Francisco');
        $orderClause = array('name'=>'asc');
        $limit = 20;
        $offset = 10;
        $tg = new DbDataGateway;
        $tg->setTableGateway($this->dbtable);
        $this->dbtable->expects($this->once())
            ->method('fetchAll')->with(
                $where,
                $orderClause,
                $limit,
                $offset
            )
            ->will($this->returnValue(
                $this->dbrowset
            ));
        $tg->find($where, $orderClause, $limit, $offset);
    }

}
