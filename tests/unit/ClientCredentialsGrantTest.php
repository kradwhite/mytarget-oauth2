<?php
/**
 * User: Aleksandrov Artem
 * Date: 24.10.2019
 * Time: 20:59
 */

namespace kradwhite\myTarget\api\oauth2\tests\unit;

use kradwhite\myTarget\api\oauth2\grant\ClientCredentialsGrant;
use kradwhite\myTarget\api\oauth2\Oauth2;
use kradwhite\myTarget\api\oauth2\Transport;

class ClientCredentialsGrantTest extends \Codeception\Test\Unit
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
        $grant = new ClientCredentialsGrant(new MockTransport(), 'client_id', 'client_secret');
        $this->assertEquals(
            $grant->request(),
            [
                'method' => 'post',
                'path' => 'token.json',
                'options' => [
                    'form_params' => [
                        'grant_type' => 'client_credentials',
                        'client_id' => 'client_id',
                        'client_secret' => 'client_secret'
                    ]
                ]
            ]
        );
    }

    public function testRequestWithPermanent()
    {
        $grant = new ClientCredentialsGrant(new MockTransport(), 'client_id', 'client_secret');
        $this->assertEquals(
            $grant->request(true),
            [
                'method' => 'post',
                'path' => 'token.json',
                'options' => [
                    'form_params' => [
                        'grant_type' => 'client_credentials',
                        'client_id' => 'client_id',
                        'client_secret' => 'client_secret',
                        'permanent' => 'true'
                    ]
                ]
            ]
        );
    }
}