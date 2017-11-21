# Symfony 4 Demo for PHP PDX

## Install

```bash 
composer create-project symfony/skeleton symfony4demo 4.0.0-BETA1
```

## Install webserver

```bash
composer require webserver
```

Then run the server

```bash
php bin\console server:run
```

Visit the page at [http://localhost:8000](http://localhost:8000)

## Hello World

Create the controller in `src/controller`.

Make sure to have the correct namespace and return a response.

```php
<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class HelloWorld
{
    public function index()
    {
        return new Response("Hello World");
    }

}
```

Add a route to point to the controller in `config/routes.yml`

```yaml
index:
    path: /
    defaults: { _controller: 'App\Controller\HelloWorld::index' }
```

## Using Annotations for Routing

```bash
composer require annotation
```

Add use statement and docblock to the controller method.

```php
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

}
```

Modify the route config file to load annotated routes from your controllers

```yaml
controllers:
  resource: ../src/controller/
  type: annotation
```

## Capturing Values

```php
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
```

## Web Profiler and Twig

install the profiler 
```bash
composer require profiler
```

Go to [http://localhost:8000/_profiler](http://localhost:8000/_profiler) to view information on recent request

The profiler depends on Twig so the Templates directory and 
a base template file have been made for us thanks to Symfony Flex.

Modify the base file for some basic styling

```twig
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{% block title %}Welcome!{% endblock %}</title>
        {% block stylesheets %}
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/foundation/6.2.4/foundation.min.css">
        {% endblock %}
    </head>
    <body>
        {% block body %}{% endblock %}
        {% block javascripts %}
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/foundation/6.2.4/foundation.min.js"></script>
            <script>
                jQuery(function() {
                   jQuery(document).foundation();
                });
            </script>
        {% endblock %}
    </body>
</html>
```

Create a basic page template named `page.html.twig` in the template directory that extends base

```twig
{% extends 'base.html.twig' %}
{% block body %}
    <div class="row align-center">
        <div class="small-12 medium-10 large-8 columns">
            {{ content | raw }}
        </div>
    </div>
{% endblock %}
```

Replace the controller methods to use Twig

```php
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
```

Note that when viewing pages, you know get a profiler toolbar.