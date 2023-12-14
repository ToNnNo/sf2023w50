<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticationController extends AbstractController
{

    #[Route('/login', name: 'authentication_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $username = $authenticationUtils->getLastUsername();

        return $this->render('authentication/login.html.twig', [
            'username' => $username,
            'error' => $error
        ]);
    }

    #[Route('/logout', name: 'authentication_logout')]
    public function logout(): Response
    {
        throw new \Exception();
    }
}
