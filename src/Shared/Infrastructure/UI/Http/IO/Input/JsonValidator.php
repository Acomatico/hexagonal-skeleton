<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\UI\Http\IO\Input;

use App\Shared\Infrastructure\UI\Http\IO\Input\Error\InvalidPropertyError;
use App\Shared\Infrastructure\UI\Http\IO\Input\Error\MissingRequiredPropertyError;
use App\Shared\Infrastructure\UI\Http\IO\Input\Error\UndefinedError;
use JsonSchema\Validator;

class JsonValidator
{
    private Validator $schemaValidator;

    public function __construct(Validator $schemaValidator)
    {
        $this->schemaValidator = $schemaValidator;
    }

    public function validate(\stdClass $input, string $schema): array
    {
        $this->schemaValidator->validate($input, (object) ['$ref' => 'file://' . realpath($schema)]);

        return array_map(function ($validationError) {
            if ('required' === $validationError['constraint']) {
                return new MissingRequiredPropertyError($validationError['property']);
            }
            if ('format' === $validationError['constraint']) {
                return new InvalidPropertyError($validationError['property']);
            }
            if ('type' === $validationError['constraint']) {
                return new InvalidPropertyError($validationError['property']);
            }
            if ('pattern' === $validationError['constraint']) {
                return new InvalidPropertyError($validationError['property']);
            }

            return new UndefinedError($validationError['property']);
        }, $this->schemaValidator->getErrors());
    }
}
