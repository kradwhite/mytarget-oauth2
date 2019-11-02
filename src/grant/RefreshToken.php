<?php
/**
 * User: Aleksandrov Artem
 * Date: 22.10.2019
 * Time: 21:32
 */

namespace kradwhite\myTarget\api\oauth2\grant;

use GuzzleHttp\Exception\GuzzleException;
use kradwhite\myTarget\api\oauth2\Transport;

/**
 * Обновление токена доступа
 * Class RefreshToken
 * @package kradwhite\myTarget\api\oauth2\grant
 * @link https://target.my.com/adv/api-marketing/doc/authorization
 */
class RefreshToken
{
    /** @var Transport */
    private $transport;

    /** @var string */
    private $refresh_token = null;

    /** @var string */
    private $client_id;

    /** @var string */
    private $client_secret;

    /**
     * RefreshToken constructor.
     * @param Transport $transport
     * @param string $refresh_token
     * @param string $client_id
     * @param string $client_secret
     */
    public function __construct(Transport $transport, string $refresh_token, string $client_id, string $client_secret)
    {
        $this->transport = $transport;
        $this->refresh_token = $refresh_token;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function request()
    {
        $form_params = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refresh_token,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
        ];
        return $this->transport->request('post', 'token.json', ['form_params' => $form_params]);
    }
}