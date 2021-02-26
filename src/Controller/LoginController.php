<?php

namespace App\Controller;

use App\Entity\TelegramUser;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LoginController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AuthenticationManagerInterface
     */
    private $authenticationManager;

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage,
        AuthenticationManagerInterface $authenticationManager
    ) {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
    }

    public function index()
    {
        return $this->render('login.html.twig');
    }

    public function login(Request $request, ValidatorInterface $validator): Response
    {
        $user = TelegramUser::createFromRequest($request);

        $errors = $validator->validate($user);

        $dataToHash = collect($user->toHashCheckArray())
            ->transform(function ($val, $key) {
                return "$key=$val";
            })
            ->sort()
            ->join("\n");

        $hashKey = hash('sha256', '1261510074:AAH6Fi3jN7IsnQs2xj0eRXvd9k6iudCakRs', true);
        $hashHmac = hash_hmac('sha256', $dataToHash, $hashKey);

        if (count($errors) > 0 || $user->getHash() !== $hashHmac) {
            return new Response('Validation failed', 422);
        }

        return $this->loginOrCreateUser($user, $request);
    }

    private function loginOrCreateUser(TelegramUser $telegramUser, Request $request): Response
    {
        $user = $this->userRepository->findOneBy(['provider_id' => $telegramUser->getProviderId()]);

        if (!$user) {
            $user = new User();
            $user->setProviderType($telegramUser->getProviderType());
            $user->setProviderId($telegramUser->getProviderId());
            $user->setFirstName($telegramUser->getFirstName());
            $user->setLastName($telegramUser->getLastName());
            $user->setPhotoUrl($telegramUser->getPhotoUrl());

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }

        $response = new RedirectResponse("/tasks");

        $response->headers->setCookie(Cookie::create('provider_id', $telegramUser->getProviderId()));

        return $response;
    }
}