<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\Validation;

use Symfony\Component\HttpFoundation\Request;
use FK\Bundle\AttributeAuthorizationBundle\AttributeAuthorizationBundle;

class JWTTokenValidation implements JWTTokenValidationInterface
{
    /**
     * @inheritDoc
     */
    public function supports(Request $request): bool
    {
        if (!$request->headers->has(AttributeAuthorizationBundle::AUTH_HEADER_KEY)) {
            return false;
        }

        $authorizationHeader = $request->headers->get(AttributeAuthorizationBundle::AUTH_HEADER_KEY);
        $authorizationHeaderSections = explode(' ', $authorizationHeader);
        if (count($authorizationHeaderSections) !== 2 || $authorizationHeaderSections[0] !== 'Bearer') {
            return false;
        }

        return true;
    }
}