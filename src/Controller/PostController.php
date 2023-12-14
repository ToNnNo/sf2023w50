<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post', name: 'post_')]
class PostController extends AbstractController
{
    public function __construct(
        private readonly PostRepository $postRepository
    )
    {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        $posts = $this->postRepository->findAllWithUser();

        return $this->render('post/index.html.twig', [
            'posts' => $posts
        ]);
    }

    #[Route('/{slug}', name: 'show')]
    public function show(
        #[MapEntity(expr: 'repository.findBySlug(slug)')]
        Post $post
    ): Response
    {

        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }

    public function last(): Response
    {
        $posts = [];

        return $this->render('post/last.html.twig', [
            'posts' => $posts
        ]);
    }
}
