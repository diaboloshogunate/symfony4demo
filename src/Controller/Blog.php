<?php
namespace App\Controller;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Blog
{
    /**
     * @Route("blog/{slug}", name="blog view", requirements={"slug":"[a-zA-Z0-9\-]+"})
     * @param string $slug
     */
    public function view(string $slug, ManagerRegistry $doctrine, \Twig_Environment $twig)
    {
        /** @var $post \App\Entity\Post */
        $post = $doctrine->getRepository(\App\Entity\Post::class)
            ->findOneBy(['slug' => $slug]);

        if(!$post) {
            return new NotFoundHttpException();
        }

        $data = [
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
        ];

        return new Response($twig->render('page.html.twig', $data));
    }
}