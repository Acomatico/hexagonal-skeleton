<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\UI\Http\IO\Input\User\Transformer;

use App\Shared\Infrastructure\UI\Http\IO\Input\BaseInputTransformer;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

class CreateUserTransformer extends BaseInputTransformer
{
    public function transform(Request $request): \stdClass
    {
        $requestBody = $request->getContent();

        $data = $this->parseJson($requestBody);

        $this->assertValidData($data, __DIR__ . '/Schema/input.user.create_user.json');

        if ($data->password !== $data->repeatedPassword) {
            throw new BadRequestException('The passwords do not match');
        }

        return $data;
    }
}
