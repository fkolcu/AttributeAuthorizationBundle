<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager;

use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\InvalidTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;

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
        try {
            $decodedToken = $this->JWTEncoder->decode($token);
        } catch (JWTDecodeFailureException $exception) {
            throw new InvalidTokenException();
        }

        return $decodedToken;
    }
}