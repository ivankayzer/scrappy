<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TelegramAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var string
     */
    private $telegramToken;

    public function __construct(EntityManagerInterface $entityManager, RouterInterface $router, string $telegramToken)
    {
        $this->router = $router;
        $this->entityManager = $entityManager;
        $this->telegramToken = $telegramToken;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $loginUrl = $this->router->generate('login');

        return new RedirectResponse(
            $loginUrl,
            Response::HTTP_FORBIDDEN
        );
    }

    public function supports(Request $request)
    {
        return $request->attributes->get('_route') === 'connect_telegram_check';
    }

    public function getCredentials(Request $request)
    {
        return $request->request->all();
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['provider_id' => $credentials['id']]);

        if (!$user) {
            $user = new User();
            $user->setProviderType('telegram');
            $user->setProviderId($credentials['id']);
            $user->setFirstName($credentials['first_name']);
            $user->setLastName($credentials['last_name']);
            $user->setPhotoUrl($credentials['photo_url']);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        return $user;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        $targetUrl = $this->router->generate('tasks');

        return new RedirectResponse($targetUrl);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $hash = $credentials['hash'];

        $otherCredentials = collect($credentials)->except('hash')->toArray();

        $dataToHash = collect($otherCredentials)
            ->transform(function ($val, $key) {
                return "$key=$val";
            })
            ->sort()
            ->join("\n");

        $hashKey = hash('sha256', $this->telegramToken, true);
        $hashHmac = hash_hmac('sha256', $dataToHash, $hashKey);

        if ($hash !== $hashHmac) {
            return false;
        }

        return true;
    }

    public function supportsRememberMe()
    {
        return true;
    }
}