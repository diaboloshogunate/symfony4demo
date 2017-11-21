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

