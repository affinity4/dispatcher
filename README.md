# Affinity4 Dispatcher

PSR-15 Middleware Dispatcher

## Installation

```bash
composer require affinity4/dispatcher
```

## Usage

Example usage with Affinity4 Fast Route Middleware:

```php
<?php
require_once __DIR__ . '/vendor/autoload.php';

use Middlewares\ResponseTime;
use Nyholm\Psr7\Factory\Psr17Factory;
use Affinity4\MiddlewareStack\Dispatcher;
use Affinity4\Middleware\RequestHandler\RequestHandlerMiddleware;
use Affinity4\Middleware\FastRoute\FastRouteMiddleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Affinity4\MiddlewareStack\Contract;

$HttpFactory = new Psr17Factory();
$Request     = $HttpFactory->createServerRequest($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');

$route_dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $route) use ($HttpFactory) {
    $route->addRoute('GET', '/test', function($request) use ($HttpFactory) {
        $Response = $HttpFactory->createResponse(200);
        return $Response->withBody($HttpFactory->createStream('Test page'));
    });
});

$Dispatcher = new Dispatcher(
    function($Request, $next) use ($HttpFactory) {
        $Response = $next->handle($Request);

        return $Response->withBody($HttpFactory->createStream($Response->getBody() . ' and callable middleware!'));
    },
    new FastRouteMiddleware($route_dispatcher, $HttpFactory),
    new RequestHandlerMiddleware($HttpFactory)
);

$Dispatcher->setHttpFactory($HttpFactory);
$Request = $HttpFactory->createServerRequest('GET', '/test');
$Response = $Dispatcher->dispatch($Request);

echo $Response->getBody(); // Test page and callable middleware!
```