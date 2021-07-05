<?php

declare(strict_types=1);

namespace App\Shared\Application\QueryBus;

use League\Tactician\Middleware;

class QueryHandlerMiddleware implements Middleware
{
    private QueryTranslator $queryTranslator;

    private QueryResolver $queryResolver;

    public function __construct(QueryTranslator $queryTranslator, QueryResolver $queryResolver)
    {
        $this->queryTranslator = $queryTranslator;
        $this->queryResolver = $queryResolver;
    }

    public function execute($query, callable $next)
    {
        $queryHandlerServiceName = $this->queryTranslator->handlerName($query);
        $queryHandler = $this->queryResolver->instantiate($queryHandlerServiceName);

        return $queryHandler->handle($query);
    }
}
