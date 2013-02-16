<?php
use ZendApp\Test\PHPUnit\TestCase as ZendAppTestCase;
use ZendApp\Data\DomainObject as DomainObject;
class DomainObjectTest extends ZendAppTestCase
{
    public function testSetsAllowedDomainObjectProperty()
    {
        $entry = new DomainObject(array('title'=>''));
        $entry->title = 'My Title';
        $this->assertEquals('My Title', $entry->title);
    }

    /**
     *
     * @expectedException ZendApp\Data\Exception\DomainObject
     * @expectedExceptionMessage $data cannot be an empty array
     */
    public function testThrowsExceptionIfDataIsEmpty()
    {
        $entry = new DomainObject();
    }

    /**
     * @expectedException ZendApp\Data\Exception\DomainObject
     * @expectedExceptionMessage id is inmutable in this DomainObject
     */
    public function testSetsIdThrowsExceptionIfAlreadySetAndNotNull()
    {
        $data = array('id'=>1);
        $entry = new DomainObject($data);
        $entry->id = 2;
    }

    public function testSetsIdEqualsExpectedValueIfInitialValueIsNull()
    {
        $data = array('id'=>null);
        $entry = new DomainObject($data);
        $entry->id = 1;
        $this->assertEquals(1,$entry->id);
    }

    //TODO: is this really necessary
    public function testSetsIdEqualsExpectedValueIfInitialValueIs0()
    {
        $data = array('id'=>0);
        $entry = new DomainObject($data);
        $entry->id = 1;
        $this->assertEquals(1,$entry->id);
    }

    //TODO: is this really necessary
    public function testSetsIdEqualsExpectedValueIfInitialValueIsFalse()
    {
        $data = array('id'=>false);
        $entry = new DomainObject($data);
        $entry->id = 1;
        $this->assertEquals(1,$entry->id);
    }

    //TODO: is this really necessary
    public function testSetsIdEqualsExpectedValueIfInitialValueIsEmptyString()
    {
        $data = array('id'=>'');
        $entry = new DomainObject($data);
        $entry->id = 1;
        $this->assertEquals(1,$entry->id);
    }

    public function testToArrayIsExpectedDataIfNotModified()
    {
        $data=array('name'=>'Francisco', 'surname'=>'Marcos');
        $entry = new DomainObject($data);
        $this->assertEquals($data, $entry->toArray());
    }

    public function testToArrayIsExpectedDataIfModified()
    {
        $data = array('name'=>'Francisco', 'surname'=>'Marcos');
        $modifiedData = array('name'=>'Perico','surname'=>'Delgado');
        $entry = new DomainObject($data);
        $entry->name = 'Perico';
        $entry->surname = 'Delgado';
        $this->assertEquals($modifiedData, $entry->toArray());
    }

    public function testGetExpectedResultNotModified()
    {
        $data = array('name'=>'Francisco');
        $entry = new DomainObject($data);
        $this->assertEquals("Francisco",$entry->name);
    }

    public function testGetExceptedResultIfModified()
    {
        $data = array('name'=>'Francisco');
        $entry = new DomainObject($data);
        $entry->name = 'Perico';
        $this->assertEquals('Perico', $entry->name);
    }

    /**
     * @expectedException ZendApp\Data\Exception\DomainObject
     * @expectedExceptionMessage name is not present in this domain object
     */
    public function testGetUndefinedPropertyOnDomainObjectSetUpThrowsException()
    {
        $data = array('surname'=>'Marcos');
        $entry = new DomainObject($data);
        $entry->name;
    }

    /**
     * @expectedException ZendApp\Data\Exception\DomainObject
     * @expectedExceptionMessage name is not present in this domain object
     */
    public function testUnsetPropertyThrowsExceptionIfGetProperty()
    {
        $data = array('name'=>'Francisco', 'surname'=>'Marcos');
        $entry = new DomainObject($data);
        unset($entry->name);
        $entry->name;
    }

    public function testIssetPropertyIsFalseIfPropertyDoesntExist()
    {
        $data = array('name'=>'Francisco', 'surname'=>'Marcos');
        $entry = new DomainObject($data);
        $this->assertEquals(false, isset($entry->age));
    }

    public function testSetModifiesLowerCaseProperty()
    {
        $data = array('name'=>'Francisco');
        $entry = new DomainObject($data);
        $entry->Name = 'Perico';
        $this->assertEquals('Perico', $entry->Name);
    }

    public function testGetChecksForLowerCaseProperty()
    {
        $data = array('name'=>'Francisco');
        $entry = new DomainObject($data);
        $this->assertEquals('Francisco', $entry->NaME);
    }

    public function testSettingDataUpperLowerCasePropertyOnGet()
    {
        $data = array('NamE'=>'Francisco');
        $entry = new DomainObject($data);
        $this->assertEquals('Francisco', $entry->name);
    }

    public function testSettingDataUpperLowerCasePropertyOnSet()
    {
        $data = array('NaMe'=>'Francisco');
        $entry = new DomainObject($data);
        $entry->name = 'Perico';
        $this->assertEquals('Perico', $entry->Name);
    }

    public function testSetDataAddsDataToDomainObject()
    {
        $data = array('name'=>'Francisco','surname'=>'Marcos','id'=>'1');
        $keys = array('name'=>'', 'surname'=>'', 'id'=>'');
        $entry = new DomainObject($keys);
        $entry->setData($data);
        $this->assertEquals($entry->toArray(), $data);
    }

    /**
     * @expectedException \ZendApp\Data\Exception\DomainObject
     * @expectedExceptionMessage $data must be a dictionary with alpha key values
     */
    public function testThrowsExceptionIfKeysDontSatisfyCtypeAlpha()
    {
        $keys = array('name','surname','id');
        $entry = new DomainObject($keys);
    }
    //TODO: it's necesary to check id data on instantation merges
    //the data array if already has properties
    public function testSetDataIfDataNotEmptyOnInstantiation()
    {
        $keys = array('name'=>'Francisco','surname'=>'Marcos');
        $data = array('name'=>'Test', 'surname'=>'Another test');
        $entry = new DomainObject($keys);
        $entry->setData($data);
        $this->assertEquals($entry->toArray(), $data);
    }

    /**
     * @expectedException ZendApp\Data\Exception\DomainObject
     * @expectedExceptionMessage id is inmutable in this DomainObject
     */
    public function testSetDataThrowsIdExceptionIfIdAlreadyHasValue()
    {
        $keys = array('name'=>'Francisco', 'surname'=>'Marcos', 'id'=>1);
        $data = array('naMe'=>'Pepe', 'surname' => 'García', 'id'=>2);
        $entry = new DomainObject($keys);
        $entry->setData($data);
    }

    /**
     * @expectedException ZendApp\Data\Exception\DomainObject
     * @expectedExceptionMessage tel is not present in this domain object
     */
    public function testSetDataThrowsExceptionIfPropertyNotPresentOnInstantation()
    {
        $keys = array('name'=>'Francisco', 'surname'=>'Marcos', 'id'=>1);
        $data = array('tel'=>'668864332', 'surname' => 'García', 'id'=>2);
        $entry = new DomainObject($keys);
        $entry->setData($data);
    }

}
