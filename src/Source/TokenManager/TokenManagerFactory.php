<?php

namespace FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager;

use Exception;
use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\MissingConfigurationException;
use FK\Bundle\AttributeAuthorizationBundle\Source\Exceptions\UnsupportedTokenManagerException;
use FK\Bundle\AttributeAuthorizationBundle\Source\TokenManager\Plugins\TokenManagerLexik;
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
            $tokenManagerName = $this->parameterBag->get('attribute_authorization.token_manager');
        } catch (Exception) {
            throw new MissingConfigurationException("token_manager");
        }

        if ($tokenManagerName === 'LexikJWTAuthenticationBundle') {
            return new TokenManagerLexik();
        }

        throw new UnsupportedTokenManagerException();
    }
}