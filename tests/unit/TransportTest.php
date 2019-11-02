<?php

namespace kradwhite\myTarget\api\oauth2\tests\unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use kradwhite\myTarget\api\oauth2\Transport;

class TransportTest extends \Codeception\Test\Unit
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
    public function testRequestGuzzleException()
    {
        $this->tester->expectThrowable(GuzzleException::class, function () {
            $handler = new MockHandler([
                new RequestException(
                    "Error Communicating with Server",
                    new Request('POST', 'test'),
                    new Response(500)
                )
            ]);
            $transport = new Transport(new Client(['handler' => $handler]), []);
            $transport->request('post', '');
        });
    }

    public function testRequestEmpty()
    {
        $handler = new MockHandler([
            new Response(200, [], null)
        ]);
        $transport = new Transport(new Client(['handler' => $handler]), []);
        $result = $transport->request('post', '');
        $this->assertIsString($result);
    }

    public function testRequestEmptyObject()
    {
        $handler = new MockHandler([
            new Response(200, [], json_encode((object)[]))
        ]);
        $transport = new Transport(new Client(['handler' => $handler]), ['assoc' => false]);
        $result = $transport->request('post', '');
        $this->assertIsObject($result);
        $this->assertEmpty(get_object_vars($result));
    }

    public function testRequestEmptyArray()
    {
        $handler = new MockHandler([
            new Response(200, [], json_encode((object)[]))
        ]);
        $transport = new Transport(new Client(['handler' => $handler]), []);
        $result = $transport->request('post', '');
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testRequestResultArray()
    {
        $handler = new MockHandler([
            new Response(200, [], json_encode((object)['property' => 'two']))
        ]);
        $transport = new Transport(new Client(['handler' => $handler]), []);
        $result = $transport->request('post', '');
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('property', $result);
    }

    public function testRequestResultObject()
    {
        $handler = new MockHandler([
            new Response(200, [], json_encode((object)['property' => 'two']))
        ]);
        $transport = new Transport(new Client(['handler' => $handler]), ['assoc' => false]);
        $result = $transport->request('post', '');
        $this->assertIsObject($result);
        $this->assertNotEmpty(get_object_vars($result));
        $this->assertObjectHasAttribute('property', $result);
    }
}