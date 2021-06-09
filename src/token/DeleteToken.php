<?php
/**
 * User: Aleksandrov Artem
 * Date: 23.10.2019
 * Time: 08:40
 */

namespace kradwhite\myTarget\api\oauth2\token;

use GuzzleHttp\Exception\GuzzleException;
use kradwhite\myTarget\api\oauth2\Transport;

/**
 * При достижении лимита на количество токенов можно самостоятельно удалить все токены конкретного пользователя
 * Class DeleteToken
 * @package kradwhite\myTarget\api\oauth2\token
 * @link https://target.my.com/adv/api-marketing/doc/authorization
 */
class DeleteToken
{
    /** @var Transport */
    private $transport;

    /** @var string */
    private $client_id;

    /** @var string */
    private $client_secret;

    /** @var string */
    private $user_id;

    /**
     * DeleteToken constructor.
     * @param Transport $transport
     * @param string $client_id
     * @param string $client_secret
     * @param string $user_id
     */
    public function __construct(Transport $transport, string $client_id, string $client_secret, string $user_id = "")
    {
        $this->transport = $transport;
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function request()
    {
        $form_params = ['client_id' => $this->client_id, 'client_secret' => $this->client_secret];
        if ($this->user_id) {
            $form_params['username'] = $this->user_id;
        }
        return $this->transport->request('post', 'token/delete.json', ['form_params' => $form_params]);
    }
}
