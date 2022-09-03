<?php

namespace FK\Bundle\AttributeAuthorizationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('attribute_authorization');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('token_manager')
                ->defaultValue('LexikJWTAuthenticationBundle')
                ->end()
            ->end();

        return $treeBuilder;
    }
}