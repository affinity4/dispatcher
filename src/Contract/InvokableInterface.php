<?php
namespace Affinity4\Dispatcher\Contract;

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
