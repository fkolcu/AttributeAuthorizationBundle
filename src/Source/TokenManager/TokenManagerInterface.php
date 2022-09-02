<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager;

use Exception;

interface TokenManagerInterface
{
    /**
     * Decodes given JWT token using selected Token Manager
     *
     * @param string $token
     * @return array
     * @throws Exception when decoding failed
     */
    public function decode(string $token): array;
}