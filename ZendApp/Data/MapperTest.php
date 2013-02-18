<?php

declare(encoding='UTF-8');

use ZendApp\Test\PHPUnit\TestCase as ZendAppTestCase;
use ZendApp\Data\DomainObject as DomainObject;

class MapperTest extends ZendAppTestCase
{
    protected $dataGateway;
    protected $domainObjectClassName;
    protected $sutClassName;

    public function setUp()
    {
        $gatewayClassName = 'ZendApp\Data\DataGateway\DataGatewayInterface';
        $this->dataGateway = $this->getMock($gatewayClassName);
        $this->domainObjectClassName = 'ZendApp\Data\DomainObject';
        $this->sutClassName = 'ZendApp\Data\Mapper';
    }

    public function testSaveCallsInsertWhenDomainObjectHasANonEmptyId()
    {
        $constructorArgs = array(
            $this->dataGateway,
            $this->domainObjectClassName
        );
        $data = array('id'=>'1', 'name'=>'Francisco', 'surname'=>'Marcos');
        $sut = $this->getMockForAbstractClass($this->sutClassName, $constructorArgs);
        $domainObject = new DomainObject($data);
        $sut->expects($this->any())->method('insert')->with($domainObject);
        $sut->save($domainObject);
    }

    public function testSaveCallsUpdateWhenDomainObjectHasNotAnId()
    {
        $constructorArgs = array(
            $this->dataGateway,
            $this->domainObjectClassName
        );
        $data = array('name'=>'Francisco', 'surname'=>'Marcos');
        $sut = $this->getMockForAbstractClass($this->sutClassName, $constructorArgs);
        $domainObject = new DomainObject($data);
        $sut->expects($this->any())->method('update')->with($domainObject);
        $sut->save($domainObject);
    }

    public function testSaveCallsUpdateWhenDomainObjectHasAnEmptyId()
    {
        $constructorArgs = array(
            $this->dataGateway,
            $this->domainObjectClassName
        );
        $data = array('id'=>'', 'name'=>'Francisco', 'surname'=>'Marcos');
        $sut = $this->getMockForAbstractClass($this->sutClassName, $constructorArgs);
        $domainObject = new DomainObject($data);
        $sut->expects($this->any())->method('update')->with($domainObject);
        $sut->save($domainObject);
    }

    /**
     * @expectedException \ZendApp\Data\Exception\Mapper
     * @expectedExceptionMessage DataGateway is required
     */
    public function testThrowsMapperExceptionIfDataGatewayIsNotSet()
    {
        $constructorArgs = array(
            null,
            $this->domainObjectClassName
        );
        $sut = $this->getMockForAbstractClass($this->sutClassName, $constructorArgs);
    }

    /**
     * @expectedException \ZendApp\Data\Exception\Mapper
     * @expectedExceptionMessage domainObjectClassName is required
     */
    public function testThrowsMapperExceptionIfDomainObjectIsNotSet()
    {
        $constructorArgs = array(
            $this->dataGateway,
            null
        );
        $sut = $this->getMockForAbstractClass($this->sutClassName, $constructorArgs);
    }

    /**
     * @expectedException \ZendApp\Data\Exception\Mapper
     * @expectedExceptionMessage domainObjectClassName is required
     */
    public function testThrowsMapperExceptionIfDomainObjectIsEmpty()
    {
        $constructorArgs = array(
            $this->dataGateway,
            ''
        );
        $sut = $this->getMockForAbstractClass($this->sutClassName, $constructorArgs);
    }

    public function testCreateObjectCreatesADomainObjectInstance()
    {
        $constructorArgs = array(
            $this->dataGateway,
            $this->domainObjectClassName
        );
        $data = array('name'=>'Francisco','id'=>1);
        $domainObject = new DomainObject($data);
        $sut = $this->getMockForAbstractClass($this->sutClassName, $constructorArgs);
        $result = $sut->createObject($data);
        $this->assertEquals($result, $domainObject);
    }
}
