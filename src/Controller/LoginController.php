<?php

namespace App\Controller;

use App\Entity\TelegramUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LoginController extends AbstractController
{
    public function index()
    {
        return $this->render('login.html.twig');
    }

    public function login(Request $request, ValidatorInterface $validator)
    {
        $user = TelegramUser::createFromRequest($request);

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            return new Response('Validation failed', 422);
        }

        $dataToHash = collect($user->toHashCheckArray())
            ->transform(function ($val, $key) {
                return "$key=$val";
            })
            ->sort()
            ->join("\n");

        $hashKey = hash('sha256', '1261510074:AAH6Fi3jN7IsnQs2xj0eRXvd9k6iudCakRs', true);
        $hashHmac = hash_hmac('sha256', $dataToHash, $hashKey);

        if ($user->getHash() !== $hashHmac) {
            dd("Wrong hash");
        }

        echo "OK";

//        return $this->mapUserToObject($this->request->except(['auth_date', 'hash']));
    }
}