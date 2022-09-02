<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\Validation;

use Symfony\Component\HttpFoundation\Request;

interface JWTTokenValidationInterface
{
    /**
     * Checks if JWT token authentication is supported
     *
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request): bool;
}