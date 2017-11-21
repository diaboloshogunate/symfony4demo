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
    public function index()
    {
        return new Response("Hello World");
    }

    /**
     * @Route("/hello/{name}", name="hello robot", requirements={"name": "\d+"})
     * @return Response
     */
    public function robot($name)
    {
        return new Response(sprintf("Hello robot: %s.", $name));
    }

    /**
     * @Route("/hello/{name}", name="hello human")
     * @return Response
     */
    public function human($name = "john doe")
    {
        return new Response(sprintf("Hello human: %s.", $name));
    }
}
