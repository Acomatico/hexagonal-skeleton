<?php

declare(strict_types=1);

namespace App\OpenApi;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class OpenApiController
{
    private Environment $templating;

    private array $apiActiveVersions;

    private string $apiCurrentVersion;

    public function __construct(Environment $templating, array $apiActiveVersions, string $apiCurrentVersion)
    {
        $this->templating = $templating;
        $this->apiActiveVersions = $apiActiveVersions;
        $this->apiCurrentVersion = $apiCurrentVersion;
    }

    public function __invoke(string $version): Response
    {
        if ('current' === $version) {
            $version = $this->apiCurrentVersion;
        }

        if (false === in_array($version, $this->apiActiveVersions, true)) {
            throw new NotFoundHttpException();
        }

        return new Response(
            $this->templating->render('./swagger.html.twig', [
                'version' => $version
            ]),
            200,
            ['content-type' => 'text/html']
        );
    }
}
