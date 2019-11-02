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
 * Authorization Code Grant используется для получения доступа к данным сторонних аккаунтов myTarget
 * Class AuthorizationCodeGrant
 * @package kradwhite\myTarget\api\oauth2\grant
 * @link https://target.my.com/adv/api-marketing/doc/authorization
 */
class AuthorizationCodeGrant
{
    /** @var Transport */
    private $transport;

    /** @var string */
    private $code;

    /** @var string */
    private $client_id;

    /**
     * AuthorizationCodeGrant constructor.
     * @param Transport $transport
     * @param string $code
     * @param string $client_id
     */
    public function __construct(Transport $transport, string $code, string $client_id)
    {
        $this->transport = $transport;
        $this->code = $code;
        $this->client_id = $client_id;
    }

    /**
     * @param bool $permanent
     * @return mixed
     * @throws GuzzleException
     */
    public function request(bool $permanent = false)
    {
        $form_params = ['grant_type' => 'authorization_code', 'code' => $this->code, 'client_id' => $this->client_id];
        if ($permanent) {
            $form_params['permanent'] = 'true';
        }
        return $this->transport->request('post', 'token.json', ['form_params' => $form_params]);
    }
}