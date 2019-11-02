<?php

namespace kradwhite\myTarget\api\oauth2\tests\unit;

use kradwhite\myTarget\api\oauth2\token\DeleteToken;

class DeleteTokenTest extends \Codeception\Test\Unit
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
        $grant = new DeleteToken(new MockTransport(), 'client_id', 'client_secret', 'username');
        $this->assertEquals(
            $grant->request(),
            [
                'method' => 'post',
                'path' => 'token/delete.json',
                'options' => [
                    'form_params' => [
                        'client_id' => 'client_id',
                        'client_secret' => 'client_secret',
                        'username' => 'username',
                    ]
                ]
            ]
        );
    }
}