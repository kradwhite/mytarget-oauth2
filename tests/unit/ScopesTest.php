<?php

namespace kradwhite\myTarget\api\oauth2\tests\unit;

use kradwhite\myTarget\api\oauth2\Scopes;

class ScopesTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testConstants()
    {
        $this->assertEquals(Scopes::read_ads, 'read_ads');
        $this->assertEquals(Scopes::read_payments, 'read_payments');
        $this->assertEquals(Scopes::create_ads, 'create_ads');
        $this->assertEquals(Scopes::create_clients, 'create_clients');
        $this->assertEquals(Scopes::read_clients, 'read_clients');
        $this->assertEquals(Scopes::create_agency_payments, 'create_agency_payments');
        $this->assertEquals(Scopes::read_manager_clients, 'read_manager_clients');
        $this->assertEquals(Scopes::edit_manager_clients, 'edit_manager_clients');
        $this->assertEquals(Scopes::read_payments, 'read_payments');
    }

    public function testAll()
    {
        $this->assertEquals(
            Scopes::all(),
            "read_ads,read_payments,create_ads,create_clients,read_clients,create_agency_payments,read_manager_clients,edit_manager_clients"
        );
    }

    public function testAllForClient()
    {
        $this->assertEquals(Scopes::allForClient(), "read_ads,read_payments,create_ads");
    }

    public function testAllForAgencyAndDelegate()
    {
        $this->assertEquals(Scopes::allForAgencyAndDelegate(), "create_clients,read_clients,create_agency_payments");
    }

    public function testAllForManager()
    {
        $this->assertEquals(Scopes::allForManager(), "read_payments,read_manager_clients,edit_manager_clients");
    }

    public function testAllForRead()
    {
        $this->assertEquals(Scopes::allForRead(), "read_ads,read_payments,read_clients,read_manager_clients");
    }
}