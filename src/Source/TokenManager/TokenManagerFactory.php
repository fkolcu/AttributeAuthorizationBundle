<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager;

use FK\Bundle\AttributeAuthorizationBundle\AttributeAuthorizationBundle;
use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\MissingConfigurationException;
use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\UnsupportedTokenManagerException;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TokenManagerFactory implements TokenManagerFactoryInterface
{
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    /**
     * @inheritDoc
     */
    public function getTokenManager(): TokenManagerInterface
    {
        try {
            $tokenManagerName = $this->parameterBag->get(AttributeAuthorizationBundle::BUNDLE_SERVICE_PREFIX . '.token_manager');
        } catch (ParameterNotFoundException) {
            throw new MissingConfigurationException("token_manager");
        }

        if ($tokenManagerName === 'LexikJWTAuthenticationBundle') {
            return new TokenManagerLexik();
        }

        throw new UnsupportedTokenManagerException();
    }
}