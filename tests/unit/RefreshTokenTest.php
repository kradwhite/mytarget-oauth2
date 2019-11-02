<?php

namespace kradwhite\myTarget\api\oauth2\tests\unit;

use kradwhite\myTarget\api\oauth2\grant\RefreshToken;

class RefreshTokenTest extends \Codeception\Test\Unit
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
    public function testReques()
    {
        $grant = new RefreshToken(new MockTransport(), 'token', 'client_id', 'client_secret');
        $this->assertEquals(
            $grant->request(),
            [
                'method' => 'post',
                'path' => 'token.json',
                'options' => [
                    'form_params' => [
                        'grant_type' => 'refresh_token',
                        'refresh_token' => 'token',
                        'client_id' => 'client_id',
                        'client_secret' => 'client_secret',
                    ]
                ]
            ]
        );
    }
}