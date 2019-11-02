<?php

namespace kradwhite\myTarget\api\oauth2\tests\unit;

use kradwhite\myTarget\api\oauth2\grant\Authorize;

class AuthorizeTest extends \Codeception\Test\Unit
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
    public function testRequest()
    {
        $grant = new Authorize(new MockTransport(), 'client_id', 'state', 'scope');
        $this->assertEquals(
            $grant->request(),
            [
                'method' => 'get',
                'path' => '/oauth2/authorize',
                'options' => [
                    'query' => [
                        'response_type' => 'code',
                        'client_id' => 'client_id',
                        'state' => 'state',
                        'scope' => 'scope'
                    ]
                ]
            ]
        );
    }
}