<?php

use ZendApp\Data\DataGateway\DbDataGateway as DbDataGateway;

class DataMapperTest extends PHPUnit_Framework_TestCase
{
    protected $dbtable = null;

    public function setUp()
    {
        $this->dbtable = $this->_getCleanMock('Zend_Db_Table');
        $this->dbrowset = $this->_getCleanMock('Zend_Db_Table_Rowset');
    }

    public function testInsertMethod()
    {
        $insertionData = array(
            'name' => 'Francisco',
            'surname' => 'Papa',
            'id' => ''
        );
        $dbgateway = new DbDataGateway();
        $dbgateway->setTableGateway($this->dbtable);
        $dbgateway->getTableGateway()
        ->expects($this->once())->method('insert')
        ->with($this->equalTo($insertionData))
        ->will($this->returnValue(123));
        $id = $dbgateway->insert($insertionData);
        $this->assertEquals(123, $id);
    }

    public function testUpdateMethod()
    {
        $updateData = array('name'=>'Francisco','surname'=>'Marcos');
        $where = array('update 1','update 2');
        $dbgateway = new DbDataGateway();
        $dbgateway->setTableGateway($this->dbtable);
        $dbgateway->getTableGateway()->expects($this->once())
            ->method('update')->with(
                $this->equalTo($updateData),
                $this->equalTo($where)
            )->will($this->returnValue(1));
        $numRows = $dbgateway->update($updateData, $where);
        $this->assertEquals(1, $numRows);
    }

    public function testDeleteMethod()
    {
        $where = array('where 1', 'where 2');
        $dbgateway = new DbDataGateway();
        $dbgateway->setTableGateway($this->dbtable);
        $dbgateway->getTableGateway()->expects($this->once())
            ->method('delete')->with($this->equalTo($where))
            ->will($this->returnValue(1));
        $numRows = $dbgateway->delete($where);
        $this->assertEquals(1, $numRows);
    }

    public function testFind()
    {
        $where = 'id';
        $dbgateway = new DbDataGateway();
        $dbgateway->setTableGateway($this->dbtable);
        $dbgateway->getTableGateway()->expects($this->once())
            ->method('find')->with($this->equalTo($where))
            ->will($this->returnValue($this->dbrowset));
        $dbgateway->find('id');
    }

    private function _getCleanMock($className)
    {
        $class = new ReflectionClass($className);
        $methods = $class->getMethods();
        $stubMethods = array();
        foreach ($methods as $method) {
            if($method->isPublic()||($method->isProtected() && $method->isAbstract()))
            {
                $stubMethods[] = $method->getName();
            }
        }
        return $this->getMock($className, $stubMethods, array(), $className.'_Test_'.uniqid(), false);
    }
}
