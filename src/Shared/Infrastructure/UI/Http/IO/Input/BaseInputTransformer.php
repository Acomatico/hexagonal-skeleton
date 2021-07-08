<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\Http\IO\Input;

use App\Shared\Infrastructure\UI\Http\IO\Exception\TransformerException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseInputTransformer
{
    private JsonValidator $validator;

    public function __construct(JsonValidator $validator)
    {
        $this->validator = $validator;
    }

    public abstract function transform(Request $request): \stdClass;

    protected function parseJson(string $json): \stdClass
    {
        $data = json_decode($json);

        if (null === $data) {
            throw new BadRequestException();
        }

        return $data;
    }

    protected function assertValidData(\stdClass $data, string $schema): void
    {
        $errors = $this->validator->validate(
            $data,
            $schema
        );

        if (0 !== count($errors)) {
            throw new TransformerException($errors);
        }
    }
}
