<?php

namespace App\Controller;

use App\Dto\TelegramUser;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\TelegramClient;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function index()
    {
        return $this->render('login.html.twig');
    }

    public function connectTelegram(Request $request, TelegramClient $client): Response
    {
        $client->setAsStateless();

        try {
            // the exact class depends on which provider you're using
            /** @var \League\OAuth2\Client\Provider\FacebookUser $user */
            $user = $client->fetchUser();

            // do something with all this new power!
            // e.g. $name = $user->getFirstName();
            var_dump($user); die;
            // ...
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            var_dump($e->getMessage()); die;
        }
//        $errors = $validator->validate($user);
//
//        $dataToHash = collect($user->toHashCheckArray())
//            ->transform(function ($val, $key) {
//                return "$key=$val";
//            })
//            ->sort()
//            ->join("\n");
//
//        $hashKey = hash('sha256', '1261510074:AAH6Fi3jN7IsnQs2xj0eRXvd9k6iudCakRs', true);
//        $hashHmac = hash_hmac('sha256', $dataToHash, $hashKey);
//
//        if (count($errors) > 0 || $user->getHash() !== $hashHmac) {
//            return new Response('Validation failed', 422);
//        }
//
//        return $this->loginOrCreateUser($user);
    }

    private function loginOrCreateUser(TelegramUser $telegramUser): Response
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

        return new RedirectResponse("/tasks");
    }
}