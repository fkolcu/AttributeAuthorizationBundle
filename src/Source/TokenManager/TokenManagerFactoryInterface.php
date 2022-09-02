<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager;

use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\MissingConfigurationException;
use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\UnsupportedTokenManagerException;

interface TokenManagerFactoryInterface
{
    /**
     * @return TokenManagerInterface
     * @throws UnsupportedTokenManagerException
     * @throws MissingConfigurationException
     */
    public function getTokenManager(): TokenManagerInterface;
}