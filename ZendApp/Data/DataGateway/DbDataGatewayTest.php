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

}
