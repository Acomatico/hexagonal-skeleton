<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\Http\IO\Input\User;

use App\Shared\Infrastructure\UI\Http\IO\Input\BaseInputTransformer;
use Symfony\Component\HttpFoundation\Request;

class CreateUserTransformer extends BaseInputTransformer
{
    public function transform(Request $request): \stdClass
    {
        $requestBody = $request->getContent();

        $data = $this->parseJson($requestBody);

        $this->assertValidData($data, __DIR__ . '/Schema/input.user.create_user.json');

        return $data;
    }
}
