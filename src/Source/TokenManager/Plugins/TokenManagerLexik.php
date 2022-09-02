<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager\Plugins;

use FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager\TokenManagerInterface;

class TokenManagerLexik implements TokenManagerInterface
{
    /**
     * @inheritDoc
     */
    public function decode(string $token): array
    {
        // TODO: Implement decode() method.
    }
}