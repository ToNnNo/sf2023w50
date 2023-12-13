<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * /formation/offre-special -> priority 0
 * /formation/{slug}        -> priority -1
 */

#[Route('/admin/post', name: 'admin_post_', requirements: ['id' => '\d+'])]
class AdminPostController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly PostRepository         $postRepository
    )
    {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        $posts = $this->postRepository->findAll();

        return $this->render('admin/admin_post/index.html.twig', [
            'posts' => $posts
        ]);
    }

    /** Voir impact dans profiler > routing */
    #[Route('/{id}', name: 'detail', methods: 'GET', priority: -1)]
    public function detail(int $id): Response
    {
        $post = $this->postRepository->find($id);

        if(!$post) {
            throw $this->createNotFoundException();
        }

        return $this->render('admin/admin_post/detail.html.twig', [
            'post' => $post
        ]);
    }

    #[Route('/static/insert', name: 'static_insert')]
    public function staticInsert(): Response
    {
        $post = (new Post())
            ->setTitle('Initiation à Symfony')
            ->setSlug('initiation-a-symfony')
            ->setContent("<p>Symfony c'est vraiment bien</p>")
            ->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        $this->addFlash('success',
            sprintf("L'article \"%s\" a bien été enregistré", $post->getTitle())
        );

        return $this->redirectToRoute('admin_post_index');
    }
}
