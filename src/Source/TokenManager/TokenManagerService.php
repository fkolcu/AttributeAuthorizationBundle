<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager;

use Symfony\Component\HttpFoundation\Request;
use FK\Bundle\AttributeAuthorizationBundle\Source\User;
use Symfony\Component\Security\Core\User\UserInterface;
use FK\Bundle\AttributeAuthorizationBundle\AttributeAuthorizationBundle;

class TokenManagerService implements TokenManagerServiceInterface
{
    private TokenManagerFactoryInterface $tokenManagerFactory;

    public function __construct(TokenManagerFactoryInterface $tokenManagerFactory)
    {
        $this->tokenManagerFactory = $tokenManagerFactory;
    }

    /**
     * @inheritDoc
     */
    public function obtainToken(Request $request): string
    {
        $authorizationHeader = $request->headers->get(AttributeAuthorizationBundle::AUTH_HEADER_KEY);
        return explode(' ', $authorizationHeader)[1] ?? "";
    }

    /**
     * @inheritDoc
     */
    public function resolveToken(string $token): ?UserInterface
    {
        $tokenManager = $this->tokenManagerFactory->getTokenManager();
        $decodedTokenData = $tokenManager->decode($token);

        $identifier = $decodedTokenData['identifier'] ?? null;
        if (is_null($identifier)) {
            return null;
        }

        $roles = $decodedTokenData['roles'] ?? null;
        if (!isset($roles) || !is_array($roles)) {
            $roles = ['ROLE_USER'];
        }

        return new User($identifier, $roles);
    }
}