<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/error', name: 'error_index')]
    public function index(): Response
    {
        $pageNotFound = $this->generateUrl('error_not_found');

        return $this->render('error/index.html.twig', [
            'page_not_found' => $pageNotFound
        ]);
    }

    #[Route('/error/not-found', name: 'error_not_found')]
    public function notFound(): Response
    {
        throw $this->createNotFoundException("Exemple d'appel à une erreur 404");

        // throw $this->createAccessDeniedException(); // 401
        // throw new \Exception(); // 500
    }
}
