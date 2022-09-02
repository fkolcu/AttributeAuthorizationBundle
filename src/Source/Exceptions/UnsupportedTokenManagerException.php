<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class UnsupportedTokenManagerException extends Exception implements HttpExceptionInterface
{
    protected $message = "Unsupported token manager provided";

    public function getStatusCode(): int
    {
        return 500;
    }

    public function getHeaders(): array
    {
        return [];
    }
}