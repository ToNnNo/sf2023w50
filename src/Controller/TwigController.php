<?php

namespace App\Controller;

use App\ValueObject\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{
    #[Route('/twig', name: 'twig_index')]
    public function index(): Response
    {
        $date = new \DateTime();

        $html = "<b>Hello World</b>";

        // dd($date); // dump and die

        // dump($date);

        return $this->render('twig/index.html.twig', [
            'name' => "Stéphane",
            'date' => $date,
            'html' => $html
        ]);
    }

    #[Route('/twig/structure', name: 'twig_structure')]
    public function structure(): Response
    {
        $contact = [
            'firstname' => "John",
            'lastname' => "Doe",
            'email' => "john.doe@gmail.com"
        ];

        $objContact = new Contact('Eduard', 'Smith');

        $templateName = "structure";

        return $this->render('twig/'.$templateName.'.html.twig', [
            'contact' => $contact,
            'obj_contact' => $objContact
        ]);
    }
}
