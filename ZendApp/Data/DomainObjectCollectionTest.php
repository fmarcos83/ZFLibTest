<?php

declare(encoding='UTF-8');

use ZendApp\Test\PHPUnit\TestCase as ZendAppTestCase;
use ZendApp\Data\DomainObjectCollection as DomainObjectCollection;
use ZendApp\Data\DomainObject as DomainObject;
use ZendApp\Data\DataGateway\DataGatewayInterface as DataGatewayInterface;
use ZendApp\Data\Mapper as DataMapper;

class DomainObjectCollectionTest extends ZendAppTestCase
{
    protected $mapper;
    protected $data;
    protected $domainObjectClassName;

    public function setUp()
    {
        $this->domainObjectClassName = "ZendApp\Data\DomainObject";
        $dataGatewayClassName = "ZendApp\Data\DataGateway\DataGatewayInterface";
        $gateway = $this->getMock($dataGatewayClassName);
        $mapper = $this->getMockForAbstractClass(
            "ZendApp\Data\Mapper",array(
                $gateway,
                $this->domainObjectClassName
            )
        );
        $this->mapper = $mapper;
        $this->data = array(
            array(
                'name'=>'Francisco',
                'id'=>'1'
            ),
            array(
                'name' => 'Perico',
                'id' => 2
            ),
            array(
                'name' => 'Recesvinto',
                'id' => 3
            )
        );
    }

    public function testCheckCurrentReturnsDomainObjectInstance()
    {
        $objcoll = new DomainObjectCollection($this->data, $this->mapper);
        $this->assertInstanceOf($this->domainObjectClassName, $objcoll->current());
    }

    public function testCheckCurrentAllwaysReturnsDomainObjectInstance()
    {
        $objcoll = new DomainObjectCollection($this->data, $this->mapper);
        foreach($objcoll as $anobjcoll){
            $this->assertInstanceOf($this->domainObjectClassName, $anobjcoll);
        }
    }

    public function testCountIsExpectedArrayDataSize()
    {
        $objcoll = new DomainObjectCollection($this->data, $this->mapper);
        $this->assertEquals(3, count($objcoll));
    }

    public function testAddIncrementCounter()
    {
        $objcoll = new DomainObjectCollection($this->data, $this->mapper);
        $objcoll->add(new DomainObject(array('a'=>'ad')));
        $this->assertEquals(4, count($objcoll));
    }

    public function testAddIncrementsObjectsArray()
    {
        $objcoll = new DomainObjectCollection($this->data, $this->mapper);
        $objcoll->add(new DomainObject(array('a'=>'ad')));
        $this->assertEquals(4, count(iterator_to_array($objcoll)));
    }

    public function testRewindGetsFirstDomainObject()
    {
        $objcoll = new DomainObjectCollection($this->data, $this->mapper);
        $objcoll->next();
        $domainObject = new DomainObject(array('name'=>'Francisco','id'=>'1'));
        $result = $objcoll->rewind();
        $this->assertEquals($result, $domainObject);
    }
}
