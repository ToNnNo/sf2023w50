<?php

namespace App\Controller;

use App\Service\MessageGenerator;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/provider', name: 'provider_')]
class ProviderController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly MessageGenerator $messageGenerator
    )
    {
    }


    #[Route('', name: 'index')]
    public function index(): Response
    {
        $this->logger->notice('Nous utilisons le service logger !');

        $message = $this->messageGenerator->getHappyMessage();

        return $this->render('provider/index.html.twig', [
            'message' => $message
        ]);
    }
}
