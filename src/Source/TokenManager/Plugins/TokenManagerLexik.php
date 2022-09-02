<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager\Plugins;

use FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager\TokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class TokenManagerLexik implements TokenManagerInterface
{
    private JWTEncoderInterface $JWTEncoder;

    public function __construct(JWTEncoderInterface $JWTEncoder)
    {
        $this->JWTEncoder = $JWTEncoder;
    }

    /**
     * @inheritDoc
     */
    public function decode(string $token): array
    {
        return $this->JWTEncoder->decode($token);
    }
}