<?php
namespace Affinity4\Dispatcher;

use Relay\Relay;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Dispatcher
 */
class Dispatcher extends Relay
{
    /**
     * @var \Nyholm\Psr7\Factory\Psr17Factory
     */
    private $HttpFactory;

    /**
     * Constructor
     * 
     * @param arglist $middleware
     */
    public function __construct(...$middleware)
    {
        parent::__construct($middleware, new MiddlewareResolver);
    }

    /**
     * Set Http Factory
     * 
     * @param \Nyholm\Psr7\Factory\Psr17Factory $HttpFactory
     */
    public function setHttpFactory(Psr17Factory $HttpFactory)
    {
        $this->HttpFactory = $HttpFactory;
    }

    /**
     * Dispatch
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $Request
     * 
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function dispatch(ServerRequestInterface $Request = null): ResponseInterface
    {
        if ($Request === null) {
            if ($this->HttpFactory === null) {
                $class = __CLASS__;
                $method = __METHOD__;
                throw new \Exception("No ServerRequest instance passed to $class::$method and HttpFactory property was not set!");
            }

            $request_method = (isset($_SERVER) && array_key_exists('REQUEST_METHOD', $_SERVER))
                ? $_SERVER['REQUEST_METHOD']
                : 'GET';
            $request_uri    = (isset($_SERVER) && array_key_exists('REQUEST_URI', $_SERVER))
                ? $this->HttpFactory->createUri($_SERVER['REQUEST_URI']) 
                : $this->HttpFactory->createUri('/');

            $Request = $this->HttpFactory->createServerRequest($request_method, $request_uri);
        }

        return $this->handle($Request);
    }
}