<?php

namespace App\Controller;

use App\Form\PostType;
use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
class MainController extends AbstractController
{
    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    /**
     * @Route("/main", name="app_main")
     */
    public function index(): Response
    {
        $posts = $this->em->getRepository(Post::class)->findAll();

        return $this->render('main/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/create-post", name="create-post")
     */
    public function createPost(request $request): Response
    {
        $post = new Post();
        $post->setSubdate(new \DateTime());
        $post->setEditdate(new \DateTime());
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($post);
            $this->em->flush();

            $this->addFlash("success", "El post se ha creado correctamente");

            return $this->redirectToRoute('app_main');
        }
        return $this->render('main/post.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit-post/{id}", name="edit-post")
     */
    public function editpost(Request $request, $id): Response
    {
        $post = $this->em->getRepository(Post::class)->find($id);
        $post->setEditdate(new \DateTime());

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($post);
            $this->em->flush();
            $this->addFlash("success", "El post se ha editado correctamente");
            return $this->redirectToRoute('app_main');
        }

        return $this->render('main/post.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete-post/{id}", name="delete-post")
     */
    public function deletepost($id): Response
    {
        $post = $this->em->getRepository(Post::class)->find($id);

        $this->em->remove($post);
        $this->em->flush();
        $this->addFlash("success", "El post se ha eliminado correctamente");
        return $this->redirectToRoute('app_main');
    }

}
