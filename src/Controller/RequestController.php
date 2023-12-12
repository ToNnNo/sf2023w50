<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestController extends AbstractController
{
    #[Route('/request', name: 'request_index')]
    public function index(Request $request): Response
    {
        // http://localhost:8000/request?name=john

        // dump($request);

        $name = $request->query->get('name', 'john');

        $fullname = match ($name) {
            'john' => 'John Doe',
            'jane' => 'Jane Doe',
            default => 'Visiteur'
        };

        $session = $request->getSession();
        $panier = $session->get('panier', 'vide');

        return $this->render('request/index.html.twig', [
            'fullname' => $fullname,
            'panier' => $panier
        ]);
    }

    #[Route('/request/session', name: 'request_session')]
    public function session(Request $request): Response
    {
        $session = $request->getSession();
        $session->set('panier', 'Pomme');

        $this->addFlash('success', "La pomme a bien été ajouté dans le panier");

        return $this->redirectToRoute('request_index');
    }

    #[Route('/request/session/clear', name: 'request_session_clear')]
    public function clearSession(Request $request): Response
    {
        $session = $request->getSession();
        // $session->clear();
        $session->remove('panier');

        $this->addFlash('success', "La panier a été vidé");

        return $this->redirectToRoute('request_index');
    }
}
