<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InvalidTokenException extends \Exception implements HttpExceptionInterface
{
    protected $message = "Invalid or expired JWT token";

    /**
     * @inheritDoc
     */
    public function getStatusCode(): int
    {
        return 400;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return [];
    }
}