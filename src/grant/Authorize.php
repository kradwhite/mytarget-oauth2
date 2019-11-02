<?php
/**
 * User: Aleksandrov Artem
 * Date: 22.10.2019
 * Time: 20:04
 */

namespace kradwhite\myTarget\api\oauth2\grant;

use GuzzleHttp\Exception\GuzzleException;
use kradwhite\myTarget\api\oauth2\Transport;

/**
 * Запрос на получение кода, который будет отправлен по адресу заданному параметром "redirect_uri" при регистрации клиента
 * Class Authorize
 * @package kradwhite\myTarget\api\oauth2\authorization_code_grant
 * @link https://target.my.com/adv/api-marketing/doc/authorization
 */
class Authorize
{
    /** @var Transport */
    private $transport;

    /** @var string */
    private $client_id;

    /** @var string */
    private $state;

    /** @var string */
    private $scope;

    /**
     * Authorize constructor.
     * @param Transport $client
     * @param string $client_id
     * @param string $state
     * @param string $scope
     */
    public function __construct(Transport $client, string $client_id, string $state, string $scope)
    {
        $this->transport = $client;
        $this->client_id = $client_id;
        $this->state = $state;
        $this->scope = $scope;
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function request()
    {
        $query = ['response_type' => 'code', 'client_id' => $this->client_id, 'state' => $this->state, 'scope' => $this->scope];
        return $this->transport->request('get', '/oauth2/authorize', ['query' => $query]);
    }
}