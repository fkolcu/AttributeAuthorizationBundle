<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class MissingConfigurationException extends \Exception implements HttpExceptionInterface
{
    public function __construct(string $missingConfiguration)
    {
        $message = "Missing configuration: $missingConfiguration";
        parent::__construct($message);
    }

    public function getStatusCode(): int
    {
        return 500;
    }

    public function getHeaders(): array
    {
        return [];
    }
}