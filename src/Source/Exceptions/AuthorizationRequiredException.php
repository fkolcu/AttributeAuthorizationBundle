<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class AuthorizationRequiredException extends \Exception implements HttpExceptionInterface
{
    protected $message = "Authorization required";

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