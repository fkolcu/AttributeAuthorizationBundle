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
        $treeBuilder = new TreeBuilder('fk_attribute_authorization_bundle');

        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('token_manager')->end()
            ->end();

        return $treeBuilder;
    }
}