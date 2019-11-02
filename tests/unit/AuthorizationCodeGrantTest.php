<?php

namespace kradwhite\myTarget\api\oauth2\tests\unit;

use kradwhite\myTarget\api\oauth2\grant\AuthorizationCodeGrant;

class AuthorizationCodeGrantTest extends \Codeception\Test\Unit
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
        $grant = new AuthorizationCodeGrant(new MockTransport(), 'code', 'client_id');
        $this->assertEquals(
            $grant->request(),
            [
                'method' => 'post',
                'path' => 'token.json',
                'options' => [
                    'form_params' => [
                        'grant_type' => 'authorization_code',
                        'code' => 'code',
                        'client_id' => 'client_id',
                    ]
                ]
            ]
        );
    }

    public function testRequestWithPermanent()
    {
        $grant = new AuthorizationCodeGrant(new MockTransport(), 'code', 'client_id');
        $this->assertEquals(
            $grant->request(true),
            [
                'method' => 'post',
                'path' => 'token.json',
                'options' => [
                    'form_params' => [
                        'grant_type' => 'authorization_code',
                        'code' => 'code',
                        'client_id' => 'client_id',
                        'permanent' => 'true'
                    ]
                ]
            ]
        );
    }
}