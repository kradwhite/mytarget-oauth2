<?php
/**
 * User: Aleksandrov Artem
 * Date: 24.10.2019
 * Time: 08:50
 */

namespace kradwhite\myTarget\api\oauth2;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\TransferException;

/**
 * Class Transport
 * @package kradwhite\myTarget\api\oauth2
 */
class Transport
{
    /** @var Client */
    private $client;

    /** @var bool */
    private $assoc;

    /**
     * Transport constructor.
     * @param Client $client
     * @param array $config
     */
    public function __construct(Client $client, array $config)
    {
        if (!isset($config['assoc'])) {
            $config['assoc'] = true;
        }
        $this->client = $client;
        $this->assoc = $config['assoc'];
    }

    /**
     * @param string $method
     * @param string $path
     * @param array $options
     * @return mixed
     * @throws GuzzleException
     */
    public function request(string $method, string $path, array $options = [])
    {
        $response = $this->client->request($method, $path, $options);
        if ($response->getStatusCode() > 499) {
            throw new TransferException($response->getReasonPhrase(), $response->getStatusCode());
        }
        $json = $response->getBody()->getContents();
        $result = json_decode($json, $this->assoc);
        return json_last_error() ? $json : $result;
    }
}