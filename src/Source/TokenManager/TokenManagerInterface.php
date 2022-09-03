<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager;

use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\InvalidTokenException;

interface TokenManagerInterface
{
    /**
     * Decodes given JWT token using selected Token Manager
     *
     * @param string $token
     * @return array
     * @throws InvalidTokenException when decoding failed
     */
    public function decode(string $token): array;
}