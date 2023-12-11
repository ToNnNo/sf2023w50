<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {

        return new Response(<<<HTML
<html lang="fr">
    <head>
        <title>A propos</title>
    </head>
    <body>
        <h1>A propos de notre application</h1>
        <p>Elle est vraiment très cool !</p>
        <p><a href="/">Revenir à la page d'accueil</a></p>
    </body>
</html>
HTML);
    }

    #[Route('/json', name: 'app_json_response')]
    public function jsonResponse(): JsonResponse
    {
        $user = ['firstname' => "John", 'lastname' => "Doe", 'email' => "john.doe@gmail.com"];

        return new JsonResponse($user);
    }

    #[Route('/redirection', name: 'app_redirection')]
    public function redirection(): RedirectResponse
    {

        return $this->redirectToRoute('app_about');
    }

    #[Route('/download', name: 'app_download')]
    public function download(ParameterBagInterface $parameterBag): BinaryFileResponse
    {
        // dump($parameterBag->get('download_directory'));

        return new BinaryFileResponse(
            $parameterBag->get('download_directory'). 'code-html.jpeg',
            contentDisposition: HeaderUtils::DISPOSITION_ATTACHMENT
        );
    }
}
