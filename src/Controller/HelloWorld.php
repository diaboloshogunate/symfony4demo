<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorld
{

    /**
     * @Route("/", name="hello world")
     * @return Response
     */
    public function index(\Twig_Environment $twig)
    {
        $data = [
            'title' => 'Hello World',
            'content' => '<h1>Hello World</h1>',
        ];
        return new Response($twig->render('page.html.twig', $data));
    }

    /**
     * @Route("/hello/{name}", name="hello robot", requirements={"name": "\d+"})
     * @return Response
     */
    public function robot(\Twig_Environment $twig, $name)
    {
        $data = [
            'title' => 'Hello Robot',
            'content' => '<h1>'.sprintf("Hello %s.", $name).'</h1>',
        ];
        return new Response($twig->render('page.html.twig', $data));
    }

    /**
     * @Route("/hello/{name}", name="hello human")
     * @return Response
     */
    public function human(\Twig_Environment $twig, $name = "john doe")
    {
        $data = [
            'title' => 'Hello Human',
            'content' => '<h1>'.sprintf("Hello %s.", $name).'</h1>',
        ];
        return new Response($twig->render('page.html.twig', $data));
    }
}
