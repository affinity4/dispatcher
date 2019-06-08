<?php
namespace Affinity4\Dispatcher\Contract;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * HttpFactoryMiddlewareInterface
 */
interface HttpFactoryMiddlewareInterface
{
    /**
     * Construct
     * 
     * @param \Nyholm\Psr7\Factory\Psr17Factory $HttpFactory
     */
    public function __construct(Psr17Factory $HttpFactory);

    /**
     * Process
     * 
     * @param \Psr\Http\Message\ServerRequestInterface $Request
     * @param \Psr\Http\Server\RequestHandlerInterface
     * 
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $Request, RequestHandlerInterface $RequestHandler): ResponseInterface;
}
