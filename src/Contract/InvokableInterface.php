<?php
namespace Affinity4\MiddlewareStack\Contract;

/**
 * InvokableInterface
 */
interface InvokableInterface
{
    /**
     * Invoke
     * 
     * @param mixed $arg
     */
    public function __invoke($arg);
}
