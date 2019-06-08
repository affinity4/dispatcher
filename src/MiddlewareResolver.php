<?php
namespace Affinity4\Dispatcher;

/**
 * MiddlewareResolver
 */
class MiddlewareResolver implements Contract\InvokableInterface
{
    /**
     * @{inheritdoc}
     */
    public function __invoke($class)
    {
        if (is_string($class)) {
            return new $class();
        } else {
            if (is_callable($class)) {
                return $class;
            } else {
                $callable = function($Request, $next) use ($class): \Psr\Http\Message\ResponseInterface {
                    $response = $class->process($Request, $next);
        
                    return $response;
                };
        
                return $callable;
            }
        }
    }
}
