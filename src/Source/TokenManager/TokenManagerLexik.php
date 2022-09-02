<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager;

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