<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Post;

class WallPostController extends AbstractController
{
	/**
+      * @Route("/wall/post")
+      */
    public function index()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $wallpost = new Post();
        $wallpost->setTitle('Wall post title');
        $wallpost->setText('');
        $wallpost->setLikes(0);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($wallpost);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new wall post with id '.$wallpost->getId());
    }

    	/**
+      * @Route("/wall/{id}", name="post_show")
+      */
    public function show($id)
    {
        $wallpost = $this->getDoctrine()
        ->getRepository(Post::class)
        ->find($id);

		    if (!$wallpost) {
		        throw $this->createNotFoundException(
		            'No wall post found for id '.$id
		        );
		    }

		    return new Response('Check out this great post: '.$wallpost->getTitle());

		    // or render a template
		    // in the template, print things with {{ product.name }}
		    // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}