<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\UI\Http\IO\Input\Review\Transformer;

use App\Shared\Infrastructure\UI\Http\IO\Input\BaseInputTransformer;
use Symfony\Component\HttpFoundation\Request;

class CreateReviewTransformer extends BaseInputTransformer
{
    public function transform(Request $request): \stdClass
    {
        $requestBody = $request->getContent();

        $data = $this->parseJson($requestBody);

        $this->assertValidData($data, __DIR__ . '/Schema/input.movie.create_review.json');

        return $data;
    }
}