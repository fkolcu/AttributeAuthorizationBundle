<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class InsufficientPermissionException extends \Exception implements HttpExceptionInterface
{
    protected $message = "You do not have access right";

    /**
     * @inheritDoc
     */
    public function getStatusCode(): int
    {
        return 403;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return [];
    }
}