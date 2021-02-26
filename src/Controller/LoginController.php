<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends AbstractController
{
    public function index()
    {
        return $this->render('login.html.twig');
    }

    public function login(Request $request)
    {
        dd($request->getContent());
    }
}