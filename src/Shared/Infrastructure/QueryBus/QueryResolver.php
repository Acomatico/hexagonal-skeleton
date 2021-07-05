<?php

declare(strict_types=1);

namespace App\Shared\Application\QueryBus;

use Symfony\Component\DependencyInjection\ContainerInterface;

class QueryResolver
{
    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function instantiate(string $handlerName)
    {
        $handlerName = ltrim($handlerName, '\\');
        if (false === $this->container->has($handlerName)) {
            throw new \InvalidArgumentException(
                sprintf('Handler %s was not found. Is it registered?', $handlerName)
            );
        }

        return $this->container->get($handlerName);
    }
}
