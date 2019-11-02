<?php

namespace kradwhite\myTarget\api\oauth2\tests\unit;

use kradwhite\myTarget\api\oauth2\grant\AgencyCredentialsGrant;

class AgencyCredentialsGrantTest extends \Codeception\Test\Unit
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
    public function testRequestWithoutPermanent()
    {
        $grant = new AgencyCredentialsGrant(new MockTransport(), 'client_id', 'client_secret', 'agency_client_name', 'token');
        $this->assertEquals(
            $grant->request(),
            [
                'method' => 'post',
                'path' => 'token.json',
                'options' => [
                    'form_params' => [
                        'grant_type' => 'agency_client_credentials',
                        'client_id' => 'client_id',
                        'client_secret' => 'client_secret',
                        'agency_client_name' => 'agency_client_name',
                        'access_token' => 'token'
                    ]
                ]
            ]
        );
    }

    public function testRequestWithPermanent()
    {
        $grant = new AgencyCredentialsGrant(new MockTransport(), 'client_id', 'client_secret', 'agency_client_name');
        $this->assertEquals(
            $grant->request(true),
            [
                'method' => 'post',
                'path' => 'token.json',
                'options' => [
                    'form_params' => [
                        'grant_type' => 'agency_client_credentials',
                        'client_id' => 'client_id',
                        'client_secret' => 'client_secret',
                        'agency_client_name' => 'agency_client_name',
                        'permanent' => 'true'
                    ]
                ]
            ]
        );
    }
}