<?php

declare(strict_types=1);

namespace App\Skeleton\Application\Middleware;

use App\Shared\Application\Security\AuthorizerInterface;
use League\Tactician\Middleware;

class AuthorizationMiddleware implements Middleware
{
    private AuthorizerInterface $authorizer;



    public function execute($command, callable $next)
    {
        // TODO: Implement execute() method.
    }
}