<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class AuthorizationFailedException extends \Exception implements HttpExceptionInterface
{
    protected $message = "Authorization failed due to invalid or expired token";

    /**
     * @inheritDoc
     */
    public function getStatusCode(): int
    {
        return 401;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return [];
    }
}