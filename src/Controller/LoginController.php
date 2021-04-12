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
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LoginController extends AbstractController
{
    private UserRepository $userRepository;

    private EntityManagerInterface $entityManager;

    private TokenStorageInterface $tokenStorage;

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        TokenStorageInterface $tokenStorage
    )
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function index(): Response
    {
        return $this->render('login.html.twig');
    }

    public function loginDev(): RedirectResponse
    {
        $loginDevIsEnabled = $this->getParameter('app.login_dev_is_enabled') === "true";

        if (!$loginDevIsEnabled) {
            throw new UnauthorizedHttpException('You Shall Not Pass');
        }

        $user = $this->userRepository->findOneBy([]);

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());

        $this->tokenStorage->setToken($token);

        return $this->redirectToRoute("tasks");
    }
}