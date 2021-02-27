<?php


namespace App\Security;


use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class TelegramProvider extends AbstractProvider
{
    public function getBaseAuthorizationUrl()
    {
        return null;
    }

    public function getBaseAccessTokenUrl(array $params)
    {
        return null;
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return null;
    }

    protected function getDefaultScopes()
    {
        return [];
    }

    protected function checkResponse(ResponseInterface $response, $data)
    {
        dd($response, $data);
    }

    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new TelegramResourceOwner($response);
    }
}