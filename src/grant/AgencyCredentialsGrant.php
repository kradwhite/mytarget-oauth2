<?php
/**
 * User: Aleksandrov Artem
 * Date: 21.10.2019
 * Time: 21:51
 */

namespace kradwhite\myTarget\api\oauth2\grant;

use GuzzleHttp\Exception\GuzzleException;
use kradwhite\myTarget\api\oauth2\Transport;

/**
 * Agency Client Credentials Grant используется для работы с данными собственных клиентов агентств\менеджеров
 * Class AgencyCredentialsGrant
 * @package kradwhite\myTarget\api\oauth2\grant
 * @link https://target.my.com/adv/api-marketing/doc/authorization
 */
class AgencyCredentialsGrant
{
    /** @var Transport */
    private $transport;

    /** @var string */
    private $client_id;

    /** @var string */
    private $client_secret;

    /** @var string */
    private $agency_client_name;

    /** @var string */
    private $access_token;

    /**
     * AgencyCredentialsGrant constructor.
     * @param Transport $transport
     * @param string $client_id
     * @param string $client_secret
     * @param string $agency_client_name
     * @param string $access_token
     */
    public function __construct(
        Transport $transport,
        string $client_id,
        string $client_secret,
        string $agency_client_name,
        string $access_token = "")
    {
        $this->transport = $transport;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->agency_client_name = $agency_client_name;
        $this->access_token = $access_token;
    }

    /**
     * @param bool $permanent
     * @return mixed
     * @throws GuzzleException
     */
    public function request(bool $permanent = false)
    {
        $form_params = [
            'grant_type' => 'agency_client_credentials',
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'agency_client_name' => $this->agency_client_name
        ];
        if ($this->access_token) {
            $form_params['access_token'] = $this->access_token;
        }
        if ($permanent) {
            $form_params['permanent'] = 'true';
        }
        return $this->transport->request('post', 'token.json', ['form_params' => $form_params]);
    }
}