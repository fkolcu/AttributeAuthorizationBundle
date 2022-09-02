<?php

namespace FK\Bundle\AttributeAuthorizationBundle\DependencyInjection;

use FK\Bundle\AttributeAuthorizationBundle\AttributeAuthorizationBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(AttributeAuthorizationBundle::BUNDLE_SERVICE_PREFIX);

        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('token_manager')->end()
            ->end();

        return $treeBuilder;
    }
}