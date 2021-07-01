<?php

declare(strict_types=1);

namespace App\OpenApi;

use cebe\openapi\Reader;
use cebe\openapi\Writer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SpecController
{
    private array $apiActiveVersions;

    public function __construct(array $apiActiveVersions)
    {
        $this->apiActiveVersions = $apiActiveVersions;
    }

    public function __invoke(string $version, Request $request): Response
    {
        if (false === \in_array($version, $this->apiActiveVersions, true)) {
            throw new NotFoundHttpException();
        }

        $specs = Reader::readFromYamlFile(realpath(__DIR__ . '/Spec/' . $version . '/' . $version . '.openapi.yaml'));

        if ($request->query->has('validate')) {
            $specs->validate();

            return JsonResponse::create($specs->getErrors());
        }

        return new Response(Writer::writeToJson($specs));
    }
}
