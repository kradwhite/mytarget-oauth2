<?php
/**
 * User: Aleksandrov Artem
 * Date: 22.10.2019
 * Time: 20:09
 */

namespace kradwhite\myTarget\api\oauth2;

use GuzzleHttp\Client;
use kradwhite\myTarget\api\oauth2\grant\AgencyCredentialsGrant;
use kradwhite\myTarget\api\oauth2\grant\AuthorizationCodeGrant;
use kradwhite\myTarget\api\oauth2\grant\Authorize;
use kradwhite\myTarget\api\oauth2\grant\ClientCredentialsGrant;
use kradwhite\myTarget\api\oauth2\grant\RefreshToken;
use kradwhite\myTarget\api\oauth2\token\DeleteToken;

/**
 * Class Oauth2
 * @package kradwhite\myTarget\api\oauth2
 * @link https://target.my.com/adv/api-marketing/doc/authorization
 */
class Oauth2
{
    /** @var Transport */
    private $transport;

    /** @var array */
    private $config;

    /**
     * Oauth2 constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $base_uri = @$config['sandbox'] ? 'https://target-sandbox.my.com/api/v2/oauth2/' : 'https://target.my.com/api/v2/oauth2/';
        $client = new Client([
            'base_uri' => $base_uri,
            'http_errors' => false,
            'debug' => @$config['debug'],
        ]);
        $this->config = $config;
        $this->transport = new Transport($client, $config);
    }

    /**
     * @param string $client_id
     * @param string $scopes
     * @param string $state
     * @param string $response_type
     * @return string
     */
    public function authorizeLink(string $client_id, string $scopes, string $state = '', string $response_type = 'code'): string
    {
        $query = ['response_type' => $response_type, 'client_id' => $client_id, 'scope' => $scopes];
        if ($state) {
            $query['state'] = $state;
        }
        return 'https://'
            . (isset($this->config['sandbox']) && $this->config['sandbox'] ? 'target-sandbox.my.com' : 'target.my.com')
            . '/oauth2/authorize?'
            . http_build_query($query);
    }

    /**
     * Client Credentials Grant используется для работы с данными собственного аккаунта через API
     * @param string $client_id
     * @param string $client_secret
     * @return ClientCredentialsGrant
     */
    public function clientCredentialsGrant(string $client_id, string $client_secret): ClientCredentialsGrant
    {
        return new ClientCredentialsGrant($this->transport, $client_id, $client_secret);
    }

    /**
     * Agency Client Credentials Grant используется для работы с данными собственных клиентов агентств\менеджеров
     * @param string $client_id
     * @param string $client_secret
     * @param string $agency_client_name
     * @param string $access_token
     * @return AgencyCredentialsGrant
     */
    public function agencyCredentialsGrant(
        string $client_id,
        string $client_secret,
        string $agency_client_name,
        string $access_token = ""): AgencyCredentialsGrant
    {
        return new AgencyCredentialsGrant($this->transport, $client_id, $client_secret, $agency_client_name, $access_token);
    }

    /**
     * Authorization Code Grant используется для получения доступа к данным сторонних аккаунтов myTarget
     * @param string $code
     * @param string $client_id
     * @return AuthorizationCodeGrant
     */
    public function authorizationCodeGrant(string $code, string $client_id): AuthorizationCodeGrant
    {
        return new AuthorizationCodeGrant($this->transport, $code, $client_id);
    }

    /**
     * Обновление токена доступа
     * @param string $refresh_token
     * @param string $client_id
     * @param string $client_secret
     * @return RefreshToken
     */
    public function refreshToken(string $refresh_token, string $client_id, string $client_secret): RefreshToken
    {
        return new RefreshToken($this->transport, $refresh_token, $client_id, $client_secret);
    }

    /**
     * При достижении лимита на количество токенов можно самостоятельно удалить все токены конкретного пользователя
     * @param string $client_id
     * @param string $client_secret
     * @param string $username
     * @return DeleteToken
     */
    public function deleteToken(string $client_id, string $client_secret, string $username = ""): DeleteToken
    {
        return new DeleteToken($this->transport, $client_id, $client_secret, $username);
    }
}
