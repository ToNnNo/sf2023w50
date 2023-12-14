<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    #[Route('/add', name: 'add')]
    // #[IsGranted('ROLE_SUPER_ADMIN')]
    public function add(Request $request, SluggerInterface $slugger): Response
    {
        // $this->isGranted() // retourne un boolean

        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN');

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $post = $form->getData(); // $post est une instance Post
            $post->setCreatedAt(new \DateTimeImmutable());
            $post->setSlug($slugger->slug($post->getTitle()));

            $this->entityManager->persist($post);
            $this->entityManager->flush();

            $this->addFlash('success',
                sprintf("L'article \"%s\" a bien été enregistré", $post->getTitle())
            );

            return $this->redirectToRoute('admin_post_index');
        }

        return $this->render('admin/admin_post/add.html.twig', [
            'formView' => $form, // $form->createView()
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
