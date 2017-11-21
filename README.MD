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

## Doctrine

Install doctrine 
```bash
composer require doctrine
```

configure the env file with the database connection
```env
DATABASE_URL="mysql://root:@127.0.0.1:3306/symfony4demo?charset=utf8mb4&serverVersion=5.7"
```

Create the entity class
```php
<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="posts")
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $author;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $published_on;

    /**
     * @ORM\Column(type="datetime")
     */
    private $last_modified_on;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_restricted;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Post
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return Post
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPublishedOn()
    {
        return $this->published_on;
    }

    /**
     * @param mixed $published_on
     * @return Post
     */
    public function setPublishedOn($published_on)
    {
        $this->published_on = $published_on;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastModifiedOn()
    {
        return $this->last_modified_on;
    }

    /**
     * @param mixed $last_modified_on
     * @return Post
     */
    public function setLastModifiedOn($last_modified_on)
    {
        $this->last_modified_on = $last_modified_on;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getisRestricted()
    {
        return $this->is_restricted;
    }

    /**
     * @param mixed $is_restricted
     * @return Post
     */
    public function setIsRestricted($is_restricted)
    {
        $this->is_restricted = $is_restricted;
        return $this;
    }
}
```

Create the Repository class

```php
<?php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{

}
```

Create the Route. Preferable in a new Controller.
```php
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
```
