<?php
/**
 * User: Aleksandrov Artem
 * Date: 22.10.2019
 * Time: 21:25
 */

namespace kradwhite\myTarget\api\oauth2\grant;

use GuzzleHttp\Exception\GuzzleException;
use kradwhite\myTarget\api\oauth2\Transport;

/**
 * Client Credentials Grant используется для работы с данными собственного аккаунта через API
 * Class ClientCredentialsGrant
 * @package kradwhite\myTarget\api\oauth2\grant
 * @link https://target.my.com/adv/api-marketing/doc/authorization
 */
class ClientCredentialsGrant
{
    /** @var Transport */
    private $transport;

    /** @var string */
    private $client_id;

    /** @var string */
    private $client_secret;

    /**
     * ClientCredentialsGrant constructor.
     * @param Transport $transport
     * @param string $client_id
     * @param string $client_secret
     */
    public function __construct(Transport $transport, string $client_id, string $client_secret)
    {
        $this->transport = $transport;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    /**
     * @param bool $permanent
     * @return mixed
     * @throws GuzzleException
     */
    public function request(bool $permanent = false)
    {
        $form_params = ['grant_type' => 'client_credentials', 'client_id' => $this->client_id, 'client_secret' => $this->client_secret];
        if ($permanent) {
            $form_params['permanent'] = 'true';
        }
        return $this->transport->request('post', 'token.json', ['form_params' => $form_params]);
    }
}