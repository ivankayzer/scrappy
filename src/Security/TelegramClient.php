<?php

/*
 * OAuth2 Client Bundle
 * Copyright (c) KnpUniversity <http://knpuniversity.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Security;

use KnpU\OAuth2ClientBundle\Client\OAuth2Client;
use KnpU\OAuth2ClientBundle\Exception\InvalidStateException;
use KnpU\OAuth2ClientBundle\Exception\MissingAuthorizationCodeException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\RequestStack;

class TelegramClient extends OAuth2Client
{
    /**
     * @var AbstractProvider
     */
    private $provider;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * OAuth2Client constructor.
     *
     * @param AbstractProvider $provider
     * @param RequestStack $requestStack
     */
    public function __construct(AbstractProvider $provider, RequestStack $requestStack)
    {
        $this->provider = $provider;
        $this->requestStack = $requestStack;
    }

    /**
     * Call this after the user is redirected back to get the access token.
     *
     * @param array $options Additional options that should be passed to the getAccessToken() of the underlying provider
     *
     * @return AccessToken|\League\OAuth2\Client\Token\AccessTokenInterface
     *
     * @throws InvalidStateException
     * @throws MissingAuthorizationCodeException
     * @throws IdentityProviderException         If token cannot be fetched
     */
    public function getAccessToken(array $options = [])
    {
        $code = $this->getCurrentRequest()->get('hash');

        if (!$code) {
            throw new MissingAuthorizationCodeException('No "code" parameter was found (usually this is a query parameter)!');
        }

        return $this->provider->getAccessToken(
            'authorization_code',
            array_merge(['code' => $code], $options)
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    private function getCurrentRequest()
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$request) {
            throw new \LogicException('There is no "current request", and it is needed to perform this action');
        }

        return $request;
    }
}
