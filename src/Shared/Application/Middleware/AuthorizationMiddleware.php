<?php

declare(strict_types=1);

namespace App\Shared\Application\Middleware;

use App\Shared\Application\Security\ApplicantInterface;
use App\Shared\Application\Security\ApplicantProviderInterface;
use App\Shared\Application\Security\AuthorizerInterface;
use App\Shared\Application\ServiceRequest;
use League\Tactician\Middleware;
use Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException;

class AuthorizationMiddleware implements Middleware
{
    private AuthorizerInterface $authorizer;

    private ApplicantProviderInterface $applicantProvier;

    public function __construct(AuthorizerInterface $authorizer, ApplicantProviderInterface $applicantProvider)
    {
        $this->authorizer = $authorizer;
        $this->applicantProvier = $applicantProvider;
    }

    public function execute($command, callable $next)
    {
        if ($command instanceof ServiceRequest) {
            $applicant = $this->applicantProvier->applicant();
            $this->verifyIfApplicantIsAllowed($command, $applicant);
        }

        return $next($command);
    }

    private function verifyIfApplicantIsAllowed($command, ApplicantInterface $applicant): void
    {
        if (!$this->authorizer->isAuthorized($applicant, $command)) {
            throw new InsufficientAuthenticationException();
        }
    }
}