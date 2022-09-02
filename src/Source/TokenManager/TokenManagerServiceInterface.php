<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager;

use Exception;
use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\MissingConfigurationException;
use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\UnsupportedTokenManagerException;
use FK\Bundle\AttributeAuthorizationBundle\Source\User;
use Symfony\Component\HttpFoundation\Request;

interface TokenManagerServiceInterface
{
    /**
     * Tries to get token from authentication header
     *
     * @param Request $request
     * @return string
     */
    public function obtainToken(Request $request): string;

    /**
     * Resolves JWT token and tries to extract user
     *
     * @param string $token
     * @return User|null
     * @throws MissingConfigurationException
     * @throws UnsupportedTokenManagerException
     * @throws Exception
     */
    public function resolveToken(string $token): ?User;
}